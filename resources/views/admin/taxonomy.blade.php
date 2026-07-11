@extends('layouts.admin')

@section('title', 'Categories & Skills')
@section('header_title', 'Categories & Skills')
@section('header_subtitle', 'Manage the master lists used across job posts and student profiles')

@section('content')
@if(session('status'))
    <div class="alert alert-success alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-check-circle-fill me-2"></i>
        {{ session('status') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show border-0 rounded-3 shadow-sm mb-4" role="alert">
        <i class="bi bi-exclamation-triangle-fill me-2"></i>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row g-4">
    <!-- Categories -->
    <div class="col-12 col-md-6">
        <div class="card-custom p-4">
            <div class="section-title">
                <i class="bi bi-tags-fill" style="color:var(--indigo);"></i>
                Job Categories
            </div>
            
            <form method="POST" action="{{ route('admin.taxonomy.category.store') }}" class="d-flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" class="form-control-custom" placeholder="New category name..." required>
                <button type="submit" class="btn-primary-custom" style="white-space:nowrap;">+ Add</button>
            </form>

            <ul class="item-list">
                @forelse($categories as $category)
                    <li>
                        <span>{{ $category->name }}</span>
                        <div class="d-flex gap-2">
                            <!-- Edit trigger -->
                            <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editCatModal{{ $category->id }}">Edit</button>
                            <!-- Delete action -->
                            <form method="POST" action="{{ route('admin.taxonomy.category.destroy', $category) }}" onsubmit="return confirm('Are you sure you want to delete this category?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-rose-custom btn-sm border-0">Delete</button>
                            </form>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editCatModal{{ $category->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 rounded-4">
                                    <form method="POST" action="{{ route('admin.taxonomy.category.update', $category) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold text-dark m-0">Edit Category</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Category Name</label>
                                                <input type="text" name="name" class="form-control-custom" value="{{ $category->name }}" required>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn-primary-custom">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="text-secondary justify-content-center">No categories found.</li>
                @endforelse
            </ul>
        </div>
    </div>

    <!-- Skills Master List -->
    <div class="col-12 col-md-6">
        <div class="card-custom p-4">
            <div class="section-title">
                <i class="bi bi-lightning-fill" style="color:var(--indigo);"></i>
                Skills Master List
            </div>

            <form method="POST" action="{{ route('admin.taxonomy.skill.store') }}" class="d-flex gap-2 mb-4">
                @csrf
                <input type="text" name="name" class="form-control-custom" placeholder="New skill name..." required>
                <button type="submit" class="btn-primary-custom" style="white-space:nowrap;">+ Add</button>
            </form>

            <ul class="item-list">
                @forelse($skills as $skill)
                    <li>
                        <span>{{ $skill->name }}</span>
                        <div class="d-flex gap-2">
                            <!-- Edit trigger -->
                            <button class="btn-ghost-custom btn-sm" data-bs-toggle="modal" data-bs-target="#editSkillModal{{ $skill->id }}">Edit</button>
                            <!-- Delete action -->
                            <form method="POST" action="{{ route('admin.taxonomy.skill.destroy', $skill) }}" onsubmit="return confirm('Are you sure you want to delete this skill?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-rose-custom btn-sm border-0">Delete</button>
                            </form>
                        </div>

                        <!-- Edit Modal -->
                        <div class="modal fade" id="editSkillModal{{ $skill->id }}" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content border-0 rounded-4">
                                    <form method="POST" action="{{ route('admin.taxonomy.skill.update', $skill) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header border-0 pb-0">
                                            <h5 class="fw-bold text-dark m-0">Edit Skill</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body pb-4">
                                            <div class="mb-3">
                                                <label class="form-label fw-semibold text-dark">Skill Name</label>
                                                <input type="text" name="name" class="form-control-custom" value="{{ $skill->name }}" required>
                                            </div>
                                            <div class="d-flex justify-content-end gap-2">
                                                <button type="button" class="btn-ghost-custom" data-bs-dismiss="modal">Cancel</button>
                                                <button type="submit" class="btn-primary-custom">Save Changes</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                @empty
                    <li class="text-secondary justify-content-center">No skills found.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>
@endsection
