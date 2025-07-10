@extends('layouts.admin')

@section('title', __('contact-messages.view_message'))

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">{{ __('contact-messages.message_details') }}</h1>
    <a href="{{ route('admin.contact-messages.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>{{ __('contact-messages.back_to_messages') }}
    </a>
</div>

<div class="admin-card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="card-title mb-0">{{ __('contact-messages.contact_message_number', ['id' => $contactMessage->id]) }}</h5>
        <span class="badge bg-{{ $contactMessage->is_read ? 'success' : 'warning' }} fs-6">
            {{ $contactMessage->is_read ? __('contact-messages.read_status') : __('contact-messages.unread_status') }}
        </span>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <h6 class="fw-bold">{{ __('contact-messages.sender_information') }}</h6>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.name') }}:</td>
                        <td>{{ $contactMessage->first_name }} {{ $contactMessage->last_name }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.email') }}:</td>
                        <td>
                            <a href="mailto:{{ $contactMessage->email }}">{{ $contactMessage->email }}</a>
                        </td>
                    </tr>
                    @if($contactMessage->phone)
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.phone') }}:</td>
                        <td>{{ $contactMessage->phone }}</td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class="col-md-6">
                <h6 class="fw-bold">{{ __('contact-messages.message_information') }}</h6>
                <table class="table table-borderless">
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.subject') }}:</td>
                        <td>{{ $contactMessage->subject ?? __('contact-messages.no_subject') }}</td>
                    </tr>
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.received') }}:</td>
                        <td>{{ $contactMessage->created_at ? $contactMessage->created_at->format('M d, Y \a\t H:i') : __('contact-messages.na') }}</td>
                    </tr>
                    @if($contactMessage->company)
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.company') }}:</td>
                        <td>{{ $contactMessage->company }}</td>
                    </tr>
                    @endif
                    <tr>
                        <td class="fw-bold">{{ __('contact-messages.status') }}:</td>
                        <td>
                            <span class="badge bg-{{ $contactMessage->is_read ? 'success' : 'warning' }}">
                                {{ $contactMessage->is_read ? __('contact-messages.read_status') : __('contact-messages.unread_status') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <hr>

        <div class="mb-4">
            <h6 class="fw-bold">{{ __('contact-messages.message_content') }}</h6>
            <div class="border p-3 bg-light rounded">
                {{ $contactMessage->message }}
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2">
            @if(!$contactMessage->is_read)
                <form action="{{ route('admin.contact-messages.mark-read', $contactMessage) }}" method="POST" class="d-inline">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="btn btn-success">
                        <i class="fas fa-check me-2"></i>{{ __('contact-messages.mark_as_read') }}
                    </button>
                </form>
            @endif
            
            <a href="mailto:{{ $contactMessage->email }}?subject=Re: {{ $contactMessage->subject }}" class="btn btn-primary">
                <i class="fas fa-reply me-2"></i>{{ __('contact-messages.reply_via_email') }}
            </a>
            
            <form action="{{ route('admin.contact-messages.destroy', $contactMessage) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('contact-messages.confirm_delete_simple') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash me-2"></i>{{ __('contact-messages.delete') }}
                </button>
            </form>
        </div>
    </div>
</div>
@endsection
