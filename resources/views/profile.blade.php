<x-layout>
<x-slot name="title">Profile - Admin Page</x-slot>

<section class="section">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible show fade">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        {{-- KAD ATAS: AVATAR & BUTANG CREATE ACCOUNT --}}
        <div class="class="col-12 col-lg-9">
            <div class="card shadow-sm mb-4">
                <div class="card-body d-flex flex-column flex-sm-row align-items-center gap-4 p-4">
                    <div class="avatar avatar-xl">
                        <img src="{{ asset('mazer/assets/compiled/jpg/1.jpg') }}" alt="Admin Avatar"
                            style="width: 72px; height: 72px; object-fit: cover;">
                    </div>
                    
                    <div>
                        <h4 class="mb-0">{{ $profile->name }}</h4>
                        <p class="text-muted mb-0">{{ $profile->role }}</p>
                    </div>

                    <span class="badge bg-{{ $profile->status === 'Active' ? 'success' : 'secondary' }}">
                        {{ $profile->status }}
                    </span>
                </div>
            </div>
        

        {{-- KAD BAWAH: BORANG EDIT PROFILE & BUTANG CHANGE PASSWORD --}}
        
            <div class="card shadow-sm">
                <div class="card-header">
                    <h4 class="card-title mb-0">Edit Profile</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profile.update') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $profile->name) }}">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $profile->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone', $profile->phone) }}">
                                @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="role" class="form-label">Role</label>
                                <input type="text" id="role" name="role" class="form-control @error('role') is-invalid @enderror" value="{{ old('role', $profile->role) }}">
                                @error('role')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select id="status" name="status" class="form-select @error('status') is-invalid @enderror">
                                    @foreach (['Active', 'Inactive'] as $status)
                                        <option value="{{ $status }}" @selected(old('status', $profile->status) === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                                @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- KAWASAN BUTANG TINDAKAN --}}
                        <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                            {{-- BUTANG CHANGE PASSWORD --}}
                            <button type="button" class="btn btn-warning text-white" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
                                <i class="bi bi-key-fill me-1"></i> Change Password
                            </button>

                            {{-- BUTANG SAVE CHANGES --}}
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- MODAL CHANGE PASSWORD --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-3 shadow">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title text-white" id="changePasswordModalLabel">
                    <i class="bi bi-key-fill me-1"></i> Change Password
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.profile.password') }}" method="POST">
                @csrf
                <div class="modal-body p-4">
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="new_password" name="new_password" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-warning text-white">Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-layout>
