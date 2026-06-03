@extends(auth()->user()->tipo_perfil === 'ADMIN' ? 'layouts.admin' : 'layouts.store')

@section('title', __('Profile') . ' | Amor em Linhas')

@section('content')
<div class="row justify-content-center py-5">
    <div class="col-md-8">
        
        <!-- Profile Information -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- Preferences -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                @include('profile.partials.update-preferences-form')
            </div>
        </div>

        <!-- Update Password -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- Delete User -->
        <div class="card shadow-sm border-0 mb-4">
            <div class="card-body p-4">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>
@endsection
