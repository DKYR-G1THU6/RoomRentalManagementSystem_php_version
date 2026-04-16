<?php

namespace App\Http\Controllers;

use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // 获取数据库中所有的房间记录 - 确保每次都获取最新数据
        $rooms = Room::latest()->get(); 
        
        // 将数据传递给前端视图 (先写好路径，视图我们待会儿建)
        return view('rooms.index', compact('rooms'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('rooms.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
   {
        
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number', // 必填项，且房间号不能重复
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0', // 必须是数字且不能是负数
            'status' => 'required|in:available,rented,maintenance', // 只能是这三种状态之一
            'description' => 'nullable|string', // 选填项
        ]);

        
        Room::create($validatedData);

        
        return redirect()->route('admin.rooms.index')->with('success', 'Add Room Successfully！');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.show', compact('room'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $room = Room::findOrFail($id);
        return view('rooms.edit', compact('room'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {        $room = Room::findOrFail($id);
                // 1. 数据验证
        // 注意：这里的 unique 规则加了拼接，意思是“房间号必须唯一，但允许和自己现在的房间号一样”
        $validatedData = $request->validate([
            'room_number' => 'required|string|max:255|unique:rooms,room_number,' . $room->id,
            'type' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:available,rented,maintenance',
            'description' => 'nullable|string',
        ]);

        // 2. 更新数据库
        $room->update($validatedData);

        // 3. 返回列表页并带上成功提示
        return redirect()->route('admin.rooms.index')->with('success', '房间信息更新成功！');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $room = Room::findOrFail($id);
        
        // 1. 执行删除操作
        $room->delete();

        // 2. 返回列表页
        return redirect()->route('admin.rooms.index')->with('success', '房间已成功删除！');
    }
}
