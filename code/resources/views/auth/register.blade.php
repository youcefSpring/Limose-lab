@extends('layouts.guest', ['title' => __('Register')])

@section('content')
<div class="text-center mb-4">
    <h3 class="fw-bold mb-2 text-gradient">{{ __('Create Account') }}</h3>
    <p class="text-muted">{{ __('Join the SGLR research community') }}</p>
</div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Success Message -->
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <div class="row">
                    <!-- Name Field -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">{{ __('Full Name') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-user"></i></span>
                            <input type="text"
                                   class="form-control @error('name') is-invalid @enderror"
                                   id="name"
                                   name="name"
                                   value="{{ old('name') }}"
                                   required
                                   autocomplete="name"
                                   autofocus
                                   placeholder="{{ __('Enter your full name') }}">
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Email Field -->
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">{{ __('Email Address') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                            <input type="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   id="email"
                                   name="email"
                                   value="{{ old('email') }}"
                                   required
                                   autocomplete="email"
                                   placeholder="{{ __('example@univ-boumerdes.dz') }}">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Phone Field -->
                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">{{ __('Phone Number') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-phone"></i></span>
                            <input type="tel"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   id="phone"
                                   name="phone"
                                   value="{{ old('phone') }}"
                                   autocomplete="tel"
                                   placeholder="{{ __('+213-XX-XX-XX-XX') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Department Field -->
                    <div class="col-md-6 mb-3">
                        <label for="department" class="form-label">{{ __('Department') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-building"></i></span>
                            <select class="form-select @error('department') is-invalid @enderror"
                                    id="department"
                                    name="department"
                                    required>
                                <option value="">{{ __('Select Department') }}</option>
                                <optgroup label="{{ __('UMBB - University of Boumerdes') }}">
                                    <option value="Laboratoire LIMOSE" {{ old('department') == 'Laboratoire LIMOSE' ? 'selected' : '' }}>{{ __('Laboratoire LIMOSE') }}</option>
                                    <option value="Faculté des Sciences" {{ old('department') == 'Faculté des Sciences' ? 'selected' : '' }}>{{ __('Faculty of Sciences') }}</option>
                                    <option value="Faculté de Technologie" {{ old('department') == 'Faculté de Technologie' ? 'selected' : '' }}>{{ __('Faculty of Technology') }}</option>
                                    <option value="Institut d'Informatique" {{ old('department') == "Institut d'Informatique" ? 'selected' : '' }}>{{ __('Computer Science Institute') }}</option>
                                    <option value="Département Mathématiques" {{ old('department') == 'Département Mathématiques' ? 'selected' : '' }}>{{ __('Mathematics Department') }}</option>
                                    <option value="Département Physique" {{ old('department') == 'Département Physique' ? 'selected' : '' }}>{{ __('Physics Department') }}</option>
                                    <option value="Département Chimie" {{ old('department') == 'Département Chimie' ? 'selected' : '' }}>{{ __('Chemistry Department') }}</option>
                                </optgroup>
                                <optgroup label="{{ __('External Institutions') }}">
                                    <option value="Université d'Alger" {{ old('department') == "Université d'Alger" ? 'selected' : '' }}>{{ __('University of Algiers') }}</option>
                                    <option value="USTHB" {{ old('department') == 'USTHB' ? 'selected' : '' }}>{{ __('USTHB') }}</option>
                                    <option value="École Nationale Polytechnique" {{ old('department') == 'École Nationale Polytechnique' ? 'selected' : '' }}>{{ __('National Polytechnic School') }}</option>
                                    <option value="Université de Constantine" {{ old('department') == 'Université de Constantine' ? 'selected' : '' }}>{{ __('University of Constantine') }}</option>
                                    <option value="International Institution" {{ old('department') == 'International Institution' ? 'selected' : '' }}>{{ __('International Institution') }}</option>
                                </optgroup>
                            </select>
                            @error('department')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Position Field -->
                <div class="mb-3">
                    <label for="position" class="form-label">{{ __('Position') }}</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                        <select class="form-select @error('position') is-invalid @enderror"
                                id="position"
                                name="position"
                                required>
                            <option value="">{{ __('Select Position') }}</option>
                            <optgroup label="{{ __('Teaching Staff') }}">
                                <option value="Professeur" {{ old('position') == 'Professeur' ? 'selected' : '' }}>{{ __('Professor') }}</option>
                                <option value="Maître de Conférences" {{ old('position') == 'Maître de Conférences' ? 'selected' : '' }}>{{ __('Associate Professor') }}</option>
                                <option value="Maître Assistant" {{ old('position') == 'Maître Assistant' ? 'selected' : '' }}>{{ __('Assistant Professor') }}</option>
                                <option value="Chargé de Cours" {{ old('position') == 'Chargé de Cours' ? 'selected' : '' }}>{{ __('Lecturer') }}</option>
                                <option value="Enseignant Contractuel" {{ old('position') == 'Enseignant Contractuel' ? 'selected' : '' }}>{{ __('Contract Teacher') }}</option>
                            </optgroup>
                            <optgroup label="{{ __('Research Staff') }}">
                                <option value="Directeur de Recherche" {{ old('position') == 'Directeur de Recherche' ? 'selected' : '' }}>{{ __('Research Director') }}</option>
                                <option value="Maître de Recherche" {{ old('position') == 'Maître de Recherche' ? 'selected' : '' }}>{{ __('Senior Researcher') }}</option>
                                <option value="Chargé de Recherche" {{ old('position') == 'Chargé de Recherche' ? 'selected' : '' }}>{{ __('Research Associate') }}</option>
                                <option value="Attaché de Recherche" {{ old('position') == 'Attaché de Recherche' ? 'selected' : '' }}>{{ __('Research Assistant') }}</option>
                            </optgroup>
                            <optgroup label="{{ __('Students') }}">
                                <option value="Doctorant" {{ old('position') == 'Doctorant' ? 'selected' : '' }}>{{ __('PhD Student') }}</option>
                                <option value="Étudiant Master" {{ old('position') == 'Étudiant Master' ? 'selected' : '' }}>{{ __('Master Student') }}</option>
                                <option value="Étudiant Licence" {{ old('position') == 'Étudiant Licence' ? 'selected' : '' }}>{{ __('Bachelor Student') }}</option>
                            </optgroup>
                            <optgroup label="{{ __('Administrative Staff') }}">
                                <option value="Directeur de Laboratoire" {{ old('position') == 'Directeur de Laboratoire' ? 'selected' : '' }}>{{ __('Laboratory Director') }}</option>
                                <option value="Responsable Technique" {{ old('position') == 'Responsable Technique' ? 'selected' : '' }}>{{ __('Technical Manager') }}</option>
                                <option value="Ingénieur de Laboratoire" {{ old('position') == 'Ingénieur de Laboratoire' ? 'selected' : '' }}>{{ __('Laboratory Engineer') }}</option>
                                <option value="Technicien" {{ old('position') == 'Technicien' ? 'selected' : '' }}>{{ __('Technician') }}</option>
                                <option value="Personnel Administratif" {{ old('position') == 'Personnel Administratif' ? 'selected' : '' }}>{{ __('Administrative Staff') }}</option>
                            </optgroup>
                        </select>
                        @error('position')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="row">
                    <!-- Password Field -->
                    <div class="col-md-6 mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock"></i></span>
                            <input type="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   id="password"
                                   name="password"
                                   required
                                   autocomplete="new-password"
                                   placeholder="{{ __('Min 8 characters') }}">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-text">
                            {{ __('Password must be at least 8 characters long') }}
                        </div>
                    </div>

                    <!-- Confirm Password Field -->
                    <div class="col-md-6 mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-lock-open"></i></span>
                            <input type="password"
                                   class="form-control"
                                   id="password_confirmation"
                                   name="password_confirmation"
                                   required
                                   autocomplete="new-password"
                                   placeholder="{{ __('Confirm your password') }}">
                        </div>
                    </div>
                </div>

                <!-- Terms and Conditions -->
                <div class="mb-4">
                    <div class="form-check">
                        <input class="form-check-input @error('terms') is-invalid @enderror"
                               type="checkbox"
                               name="terms"
                               id="terms"
                               {{ old('terms') ? 'checked' : '' }}
                               required>
                        <label class="form-check-label" for="terms">
                            {{ __('I agree to the') }}
                            <a href="{{ route('frontend.terms') }}" target="_blank" class="text-decoration-none">{{ __('Terms of Service') }}</a>
                            {{ __('and') }}
                            <a href="{{ route('frontend.privacy') }}" target="_blank" class="text-decoration-none">{{ __('Privacy Policy') }}</a>
                        </label>
                        @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Register Button -->
                <button type="submit" class="btn btn-primary w-100 mb-4">
                    <i class="fas fa-user-plus me-2"></i>{{ __('Create Account') }}
                </button>
            </form>

            <!-- Divider -->
            <div class="position-relative my-3">
                <hr class="border-0 bg-secondary" style="height: 1px;">
                <span class="position-absolute top-50 start-50 translate-middle bg-white px-3 text-muted">{{ __('or') }}</span>
            </div>

            <!-- Login Link -->
            <div class="text-center">
                <span class="text-muted">{{ __('Already have an account?') }}</span>
                <a href="{{ route('login') }}" class="btn btn-link text-decoration-none fw-bold">
                    <i class="fas fa-sign-in-alt me-1"></i>{{ __('Sign In') }}
                </a>
            </div>
@endsection

