@extends('layouts.app')

@section('title', 'Edit Profile')

@section('content')
    <div class="rr-tenant-welcome">
        <h2 class="profile-page-title">Edit Profile</h2>
        <p class="profile-page-subtitle">Manage your account information</p>
    </div>

    <!-- Display Mode -->
    <div id="displayMode" class="profile-shell">
        <div class="profile-card">
            <div class="profile-card__section">
                <label class="profile-card__label">Username</label>
                <p class="profile-card__value">{{ auth()->user()->name }}</p>
            </div>
            
            <div class="profile-card__section profile-card__section--no-border">
                <label class="profile-card__label">Email</label>
                <p class="profile-card__value">{{ auth()->user()->email }}</p>
            </div>
            
            <button type="button" onclick="toggleEditMode()" class="profile-btn profile-btn--primary">Edit Information</button>
        </div>
    </div>

    <!-- Edit Mode -->
    <div id="editMode" class="profile-shell profile-shell--hidden">
        <div class="profile-card">
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="profile-edit-form__field">
                    <label for="name" class="profile-edit-form__label">Username <span class="profile-edit-form__required">*</span></label>
                    <input 
                        type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', auth()->user()->name) }}"
                        required
                        class="profile-edit-form__control"
                    >
                    @error('name')
                        <span class="profile-edit-form__error">{{ $message }}</span>
                    @enderror
                </div>
                
                <div class="profile-edit-form__field">
                    <label for="email" class="profile-edit-form__label">Email <span class="profile-edit-form__required">*</span></label>
                    <input 
                        type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', auth()->user()->email) }}"
                        required
                        class="profile-edit-form__control"
                    >
                    @error('email')
                        <span class="profile-edit-form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="profile-edit-form__field profile-edit-form__field--password">
                    <label for="password" class="profile-edit-form__label">Password <span class="profile-edit-form__required">*</span></label>
                    <div class="profile-edit-form__control-wrap">
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="Enter new password"
                            class="profile-edit-form__control"
                        >
                        <button type="button" onclick="togglePasswordVisibility()" class="profile-edit-form__eye">
                            <span id="passwordEyeIcon">Show</span>
                        </button>
                    </div>
                    @error('password')
                        <span class="profile-edit-form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="profile-edit-form__field profile-edit-form__field--password">
                    <label for="password_confirmation" class="profile-edit-form__label">Confirm Password <span class="profile-edit-form__required">*</span></label>
                    <div class="profile-edit-form__control-wrap">
                        <input 
                            type="password" 
                            id="password_confirmation" 
                            name="password_confirmation" 
                            placeholder="Confirm new password"
                            class="profile-edit-form__control"
                        >
                        <button type="button" onclick="togglePasswordConfirmationVisibility()" class="profile-edit-form__eye">
                            <span id="passwordConfirmationEyeIcon">Show</span>
                        </button>
                    </div>
                </div>
                
                <div class="profile-edit-form__actions">
                    <button type="submit" class="profile-edit-form__button profile-edit-form__button--save">Save Changes</button>
                    <button type="button" onclick="toggleEditMode()" class="profile-edit-form__button profile-edit-form__button--cancel">Cancel</button>
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
