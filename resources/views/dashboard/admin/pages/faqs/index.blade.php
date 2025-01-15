{{-- resources/views/admin/faqs/index.blade.php --}}
@extends('dashboard.layout.layout')
@section('pageTitle')
    Manage FAQs
@endsection
@section('main-content')
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-flex align-items-center justify-content-between">
                        <h4 class="mb-0 font-size-18">Manage FAQs</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Admin</a></li>
                                <li class="breadcrumb-item active">FAQs</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="mb-4">
                        <a href="{{ route('admin.faqs.create') }}" class="btn btn-primary">Add New FAQ</a>
                    </div>
                    <div class="overflow-x-auto">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th scope="col">Question</th>
                                <th scope="col">Answer</th>
                                <th scope="col">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($faqs as $faq)
                                <tr>
                                    <td > {!! $faq->question !!}</td>
                                    <td >{!! $faq->answer !!}</td>
                                    <td >
                                         <div class="d-flex justify-content-end gap-2">
                                        <a href="{{ route('admin.faqs.edit', $faq) }}" class="btn btn-sm btn-outline-info">Edit</a>
                                       <form action="{{ route('admin.faqs.destroy', $faq) }}" method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this FAQ?');">
                                                @csrf
                                                @method('DELETE')
                                                 <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="text-center">No FAQs available yet.</td>
                            </tr>
                            @endforelse

                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
