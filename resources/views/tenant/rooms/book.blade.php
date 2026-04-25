@extends('layouts.app')

@section('title', '预订房间 - ' . $room->room_number)

@section('content')
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 32px; color: #2c3e50; margin: 0;">Book Room #{{ $room->room_number }}</h2>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 40px; grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));">
        <!-- 房间信息卡片 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); overflow: hidden; height: fit-content;">
            <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 25px; color: white;">
                <h3 style="margin: 0; font-size: 24px;">Room Information</h3>
            </div>
            
            <div style="padding: 25px;">
                <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #ecf0f1;">
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Room Number</p>
                    <p style="color: #2c3e50; font-size: 18px; font-weight: bold; margin: 0;">#{{ $room->room_number }}</p>
                </div>
                
                <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #ecf0f1;">
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Room Type</p>
                    <p style="color: #2c3e50; font-size: 18px; margin: 0;">{{ $room->type }}</p>
                </div>
                
                <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #ecf0f1;">
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Price Per Night</p>
                    <p style="color: #667eea; font-size: 28px; font-weight: bold; margin: 0;">RM{{ number_format($room->price, 2) }}</p>
                </div>
                
                @if ($room->description)
                    <div style="margin-bottom: 25px; padding-bottom: 25px; border-bottom: 1px solid #ecf0f1;">
                        <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Room Description</p>
                        <p style="color: #555; font-size: 14px; margin: 0; line-height: 1.6;">{{ $room->description }}</p>
                    </div>
                @endif
                
                <div>
                    <p style="color: #7f8c8d; font-size: 13px; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Status</p>
                    <span style="display: inline-block; background-color: #d4edda; color: #155724; padding: 8px 16px; border-radius: 20px; font-size: 13px; font-weight: 600;">Available</span>
                </div>
            </div>
        </div>
        
        <!-- 预订表单 -->
        <div style="background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); padding: 25px;">
            <h3 style="color: #2c3e50; font-size: 20px; margin-bottom: 25px;">Booking Details</h3>
            
            <form action="{{ route('tenant.store-booking', $room->id) }}" method="POST">
                @csrf
                
                <div style="margin-bottom: 25px;">
                    <label for="start_date" style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Check-in Date <span style="color: #e74c3c;">*</span></label>
                    <input 
                        type="date" 
                        id="start_date" 
                        name="start_date" 
                        value="{{ old('start_date') }}"
                        min="{{ now()->format('Y-m-d') }}"
                        required
                        style="width: 100%; padding: 12px 15px; border: 1px solid #bdc3c7; border-radius: 4px; font-size: 14px; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                        onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                    >
                    @error('start_date')
                        <span style="color: #e74c3c; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 25px;">
                    <label for="end_date" style="display: block; color: #2c3e50; font-weight: 600; margin-bottom: 8px; font-size: 14px;">Check-out Date <span style="color: #e74c3c;">*</span></label>
                    <input 
                        type="date" 
                        id="end_date" 
                        name="end_date" 
                        value="{{ old('end_date') }}"
                        min="{{ now()->addDay()->format('Y-m-d') }}"
                        required
                        style="width: 100%; padding: 12px 15px; border: 1px solid #bdc3c7; border-radius: 4px; font-size: 14px; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                        onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                    >
                    @error('end_date')
                        <span style="color: #e74c3c; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="background: linear-gradient(135deg, #f8f9fa 0%, #f1f3f5 100%); padding: 20px; border-radius: 8px; margin-bottom: 30px; border-left: 4px solid #667eea;">
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; padding-bottom: 12px; border-bottom: 1px solid #e0e0e0;">
                        <span style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 12px;">Total Days</span>
                        <span id="days_count" style="font-weight: bold; color: #667eea; font-size: 16px;">-</span>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #7f8c8d; font-weight: 600; text-transform: uppercase; font-size: 12px;">Estimated Total</span>
                        <span id="total_price" style="font-weight: bold; color: #27ae60; font-size: 24px;">RM0.00</span>
                    </div>
                </div>
                
                <button type="submit" style="width: 100%; padding: 14px; background-color: #667eea; color: white; border: none; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 15px; transition: all 0.3s; margin-bottom: 12px;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Confirm Booking</button>
                <a href="{{ route('tenant.rooms') }}" style="display: block; width: 100%; padding: 14px; text-align: center; background-color: #ecf0f1; color: #2c3e50; border-radius: 4px; font-weight: 600; cursor: pointer; font-size: 15px; transition: all 0.3s; text-decoration: none;" onmouseover="this.style.backgroundColor='#dde3e9';" onmouseout="this.style.backgroundColor='#ecf0f1';">Cancel</a>
            </form>
        </div>
    </div>
@endsection

@section('js')
    <script>
        const roomPrice = {{ $room->price }};
        const startDateInput = document.getElementById('start_date');
        const endDateInput = document.getElementById('end_date');
        const daysCount = document.getElementById('days_count');
        const totalPrice = document.getElementById('total_price');
        
        function calculatePrice() {
            if (startDateInput.value && endDateInput.value) {
                const start = new Date(startDateInput.value);
                const end = new Date(endDateInput.value);
                const diff = end - start;
                const days = Math.ceil(diff / (1000 * 60 * 60 * 24));
                
                if (days > 0) {
                    daysCount.textContent = days + ' days';
                    totalPrice.textContent = 'RM' + (days * roomPrice).toFixed(2);
                } else {
                    daysCount.textContent = '-';
                    totalPrice.textContent = 'RM0.00';
                }
            }
        }
        
        startDateInput.addEventListener('change', calculatePrice);
        endDateInput.addEventListener('change', calculatePrice);
    </script>
@endsection
