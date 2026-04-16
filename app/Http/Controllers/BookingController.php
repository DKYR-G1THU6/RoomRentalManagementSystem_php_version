<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    /**
     * 租客查看可用房间
     */
    public function availableRooms()
    {
        // 排除仍在占用期内的房间（含数据状态异常但结束日期在未来的 completed 订单）
        $occupiedRoomIds = Booking::query()
            ->whereIn('status', ['active', 'completed'])
            ->whereDate('end_date', '>=', now()->toDateString())
            ->pluck('room_id');

        $rooms = Room::query()
            ->where('status', 'available')
            ->whereNotIn('id', $occupiedRoomIds)
            ->orderBy('id')
            ->get();
        return view('tenant.rooms.available', compact('rooms'));
    }

    /**
     * 租客查看房间详情和预订页面
     */
    public function bookRoom(Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->route('tenant.rooms')->with('error', '该房间暂不可用');
        }
        return view('tenant.rooms.book', compact('room'));
    }

    /**
     * 租客提交预订
     */
    public function storeBooking(Request $request, Room $room)
    {
        if ($room->status !== 'available') {
            return redirect()->route('tenant.rooms')->with('error', '该房间暂不可用');
        }

        $validated = $request->validate([
            'start_date' => 'required|date|after_or_equal:today',
            'end_date' => 'required|date|after:start_date',
        ], [
            'start_date.after_or_equal' => '入住日期不能早于今天',
            'end_date.after' => '退住日期必须晚于入住日期',
        ]);

        // 计算天数和总价
        $startDate = new \DateTime($validated['start_date']);
        $endDate = new \DateTime($validated['end_date']);
        $days = $endDate->diff($startDate)->days;
        $totalPrice = $days * $room->price;

        // 创建预订
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'room_id' => $room->id,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'],
            'total_price' => $totalPrice,
            'status' => 'pending',
        ]);

        return redirect()->route('tenant.bookings.my')->with(
            'success',
            '预订已提交，等待管理员审批'
        );
    }

    /**
     * 租客查看自己的预订
     */
    public function myBookings()
    {
        $bookings = Auth::user()->bookings()->with('room')->latest()->get();
        return view('tenant.bookings.my', compact('bookings'));
    }

    /**
     * 租客取消预订（只能取消未通过的预订）
     */
    public function cancelBooking(Booking $booking)
    {
        // 检查是否是自己的预订
        if ($booking->user_id !== Auth::id()) {
            return redirect()->route('tenant.bookings.my')->with('error', '无权限执行此操作');
        }

        // 只能取消 pending 状态的预订
        if ($booking->status !== 'pending') {
            return redirect()->route('tenant.bookings.my')->with('error', '只有待处理的预订才能取消');
        }

        $booking->update(['status' => 'cancelled']);

        return redirect()->route('tenant.bookings.my')->with('success', '预订已取消');
    }

    /**
     * 管理员查看所有预订
     */
    public function allBookings()
    {
        $bookings = Booking::with('user', 'room')
            ->orderBy('status')
            ->latest()
            ->get();
        return view('admin.bookings.index', compact('bookings'));
    }

    /**
     * 管理员批准预订
     */
    public function approveBooking(Booking $booking)
    {
        // 使用事务确保两个更新都成功提交
        DB::transaction(function () use ($booking) {
            // 更新订单状态
            $booking->update(['status' => 'active']);
            
            // 直接更新房间状态
            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'rented', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            '预订已批准，房间状态已更新为已租赁'
        );
    }

    /**
     * 管理员拒绝预订
     */
    public function rejectBooking(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.bookings.index')->with('success', '预订已拒绝');
    }

    /**
     * 管理员完成预订
     */
    public function completeBooking(Booking $booking)
    {
        // 防止提前完成：未到退住日期不得完成订单
        if ($booking->end_date->isFuture()) {
            return redirect()->route('admin.bookings.index')->with(
                'error',
                '未到退住日期，暂不能完成该订单'
            );
        }

        // 使用事务确保两个更新都成功提交
        DB::transaction(function () use ($booking) {
            // 更新订单状态
            $booking->update(['status' => 'completed']);
            
            // 直接更新房间状态
            DB::table('rooms')
                ->where('id', $booking->room_id)
                ->update(['status' => 'available', 'updated_at' => now()]);
        });

        return redirect()->route('admin.bookings.index')->with(
            'success',
            '预订已完成，房间状态已更新为可用'
        );
    }
}
