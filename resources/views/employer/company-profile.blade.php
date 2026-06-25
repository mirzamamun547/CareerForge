@extends('layouts.employer')

@section('title', 'Company Profile')
@section('header_title', 'Company Profile')
@section('header_subtitle', 'Manage your company information visible to applicants.')

@section('content')
<div class="container-fluid p-0">
    <div class="card card-custom p-4">

        <!-- Header Row -->
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 60px; height: 60px;">
                    <i class="bi bi-building text-secondary" style="font-size: 1.5rem;"></i>
                </div>
                <div>
                    <h5 class="fw-bold text-dark mb-0" style="font-size: 1.1rem;">Company Profile</h5>
                    <span class="text-secondary" style="font-size: 0.8rem;">Manage your company details</span>
                </div>
            </div>
            <button class="btn btn-primary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.6rem 1.2rem;" onclick="toggleEdit()">
                <i class="bi bi-pencil-square"></i>
                Edit Profile
            </button>
        </div>

        <form>
            <div class="row g-4">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Name</label>
                    <input type="text" class="form-control form-control-custom" value="TechSoft Ltd." readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Email</label>
                    <input type="email" class="form-control form-control-custom" value="hr@techsoft.com" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Phone</label>
                    <input type="text" class="form-control form-control-custom" value="0171xxxxxxx" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Website</label>
                    <input type="url" class="form-control form-control-custom" value="https://techsoft.com" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Location</label>
                    <input type="text" class="form-control form-control-custom" value="Dhaka, Bangladesh" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Size</label>
                    <select class="form-select form-control-custom" disabled>
                        <option>1-10 employees</option>
                        <option>11-50 employees</option>
                        <option selected>51-200 employees</option>
                        <option>201-500 employees</option>
                        <option>500+ employees</option>
                    </select>
                </div>

                <!-- Company Logo Upload -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">Company Logo</label>
                    <div class="d-flex align-items-center gap-3">
                        <div class="bg-secondary bg-opacity-10 rounded-3 d-flex align-items-center justify-content-center" style="width: 70px; height: 70px;">
                            <i class="bi bi-image text-secondary" style="font-size: 1.5rem;"></i>
                        </div>
                        <div>
                            <button type="button" class="btn btn-sm btn-secondary-custom d-inline-flex align-items-center gap-2" style="font-size: 0.8rem;">
                                <i class="bi bi-upload"></i>
                                Change Logo
                            </button>
                            <p class="text-secondary mt-1 mb-0" style="font-size: 0.7rem;">PNG or JPG, max 2 MB</p>
                        </div>
                    </div>
                </div>

                <!-- About Company -->
                <div class="col-12">
                    <label class="form-label fw-semibold text-secondary" style="font-size: 0.85rem;">About Company</label>
                    <textarea class="form-control form-control-custom" rows="5" readonly>TechSoft Ltd. is a leading software development company focused on building innovative digital solutions. We specialize in web applications, mobile apps, and enterprise software. Our team of talented developers, designers, and project managers work collaboratively to deliver high-quality products for clients across various industries.</textarea>
                </div>
            </div>

            <div class="d-flex gap-3 mt-4 d-none" id="saveButtons">
                <button type="submit" class="btn btn-primary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;">
                    <i class="bi bi-check-lg"></i>
                    Save Changes
                </button>
                <button type="button" class="btn btn-secondary-custom d-flex align-items-center gap-2" style="font-size: 0.85rem; padding: 0.7rem 1.5rem;" onclick="toggleEdit()">
                    Cancel
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function toggleEdit() {
        const form = document.querySelector('form');
        const inputs = form.querySelectorAll('input, textarea');
        const selects = form.querySelectorAll('select');
        const saveButtons = document.getElementById('saveButtons');
        const isReadonly = inputs[0].hasAttribute('readonly');

        inputs.forEach(input => {
            if (isReadonly) {
                input.removeAttribute('readonly');
            } else {
                input.setAttribute('readonly', true);
            }
        });

        selects.forEach(select => {
            select.disabled = !select.disabled;
        });

        if (isReadonly) {
            saveButtons.classList.remove('d-none');
        } else {
            saveButtons.classList.add('d-none');
        }
    }
</script>
@endsection
