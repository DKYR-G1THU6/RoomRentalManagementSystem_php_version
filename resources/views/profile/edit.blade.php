@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div style="margin-bottom: 40px;">
        <h2 style="font-size: 32px; color: #2c3e50; margin: 0; margin-bottom: 10px;">Edit Profile</h2>
        <p style="color: #7f8c8d; margin: 0;">Manage your account information</p>
    </div>

    <!-- 显示模式 -->
    <div id="displayMode" style="width: 600px;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <div style="margin-bottom: 30px; padding-bottom: 30px; border-bottom: 1px solid #ecf0f1;">
                <label style="font-weight: 600; color: #7f8c8d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Username</label>
                <p style="font-size: 18px; color: #2c3e50; margin: 10px 0 0 0; font-weight: 500;">{{ auth()->user()->name }}</p>
            </div>
            
            <div style="margin-bottom: 30px;">
                <label style="font-weight: 600; color: #7f8c8d; text-transform: uppercase; font-size: 12px; letter-spacing: 0.5px;">Email</label>
                <p style="font-size: 18px; color: #2c3e50; margin: 10px 0 0 0; font-weight: 500;">{{ auth()->user()->email }}</p>
            </div>
            
            <button type="button" onclick="toggleEditMode()" style="padding: 12px 30px; background-color: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Edit Information</button>
        </div>
    </div>

    <!-- 编辑模式 -->
    <div id="editMode" style="width: 600px; display: none;">
        <div style="background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.08);">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div style="margin-bottom: 24px;">
                    <label for="name" style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block; font-size: 14px;">Username <span style="color: #e74c3c;">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                        style="width: 100%; padding: 12px 15px; border: 1px solid #bdc3c7; border-radius: 6px; font-size: 14px; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                        onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                    >
                    @error('name')
                        <span style="color: #e74c3c; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>
                
                <div style="margin-bottom: 24px;">
                    <label for="email" style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block; font-size: 14px;">Email <span style="color: #e74c3c;">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        style="width: 100%; padding: 12px 15px; border: 1px solid #bdc3c7; border-radius: 6px; font-size: 14px; transition: all 0.3s;"
                        onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                        onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                    >
                    @error('email')
                        <span style="color: #e74c3c; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label for="password" style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block; font-size: 14px;">Password <span style="color: #e74c3c;">*</span></label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter new password"
                            style="width: 100%; padding: 12px 15px; padding-right: 45px; border: 1px solid #bdc3c7; border-radius: 6px; font-size: 14px; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                            onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                        >
                        <button type="button" onclick="togglePasswordVisibility()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #667eea; font-size: 18px; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            <span id="passwordEyeIcon">Show</span>
                        </button>
                    </div>
                    @error('password')
                        <span style="color: #e74c3c; font-size: 13px; display: block; margin-top: 5px;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="margin-bottom: 30px;">
                    <label for="password_confirmation" style="font-weight: 600; color: #2c3e50; margin-bottom: 8px; display: block; font-size: 14px;">Confirm Password <span style="color: #e74c3c;">*</span></label>
                    <div style="position: relative;">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirm new password"
                            style="width: 100%; padding: 12px 15px; padding-right: 45px; border: 1px solid #bdc3c7; border-radius: 6px; font-size: 14px; transition: all 0.3s;"
                            onfocus="this.style.borderColor='#667eea'; this.style.boxShadow='0 0 0 3px rgba(102, 126, 234, 0.1)';"
                            onblur="this.style.borderColor='#bdc3c7'; this.style.boxShadow='none';"
                        >
                        <button type="button" onclick="togglePasswordConfirmationVisibility()" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: #667eea; font-size: 18px; padding: 0; width: 30px; height: 30px; display: flex; align-items: center; justify-content: center;">
                            <span id="passwordConfirmationEyeIcon">Show</span>
                        </button>
                    </div>
                </div>
                
                <div style="display: flex; gap: 12px;">
                    <button type="submit" style="padding: 12px 30px; background-color: #667eea; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#5568d3';" onmouseout="this.style.backgroundColor='#667eea';">Save Changes</button>
                    <button type="button" onclick="toggleEditMode()" style="padding: 12px 30px; background-color: #95a5a6; color: white; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; font-size: 14px; transition: all 0.3s;" onmouseover="this.style.backgroundColor='#7f8c8d';" onmouseout="this.style.backgroundColor='#95a5a6';">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEditMode() {
            const displayMode = document.getElementById('displayMode');
            const editMode = document.getElementById('editMode');
            
            if (displayMode.style.display === 'none') {
                displayMode.style.display = 'block';
                editMode.style.display = 'none';
            } else {
                displayMode.style.display = 'none';
                editMode.style.display = 'block';
            }
        }

        function togglePasswordVisibility() {
            const passwordInput = document.getElementById('password');
            const eyeIcon = document.getElementById('passwordEyeIcon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.textContent = 'Hide';
            } else {
                passwordInput.type = 'password';
                eyeIcon.textContent = 'Show';
            }
        }

        function togglePasswordConfirmationVisibility() {
            const passwordConfirmationInput = document.getElementById('password_confirmation');
            const eyeIcon = document.getElementById('passwordConfirmationEyeIcon');
            
            if (passwordConfirmationInput.type === 'password') {
                passwordConfirmationInput.type = 'text';
                eyeIcon.textContent = 'Hide';
            } else {
                passwordConfirmationInput.type = 'password';
                eyeIcon.textContent = 'Show';
            }
        }
    </script>
@endsection
