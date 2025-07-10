<div class="alert alert-danger d-flex align-items-start mb-4">
    <i class="fas fa-exclamation-triangle me-3 mt-1" style="font-size: 1.2rem;"></i>
    <div>
        <h6 class="alert-heading mb-2">{{ __('common.permanent_account_deletion') }}</h6>
        <p class="mb-0">{{ __('common.permanent_account_deletion_desc') }}</p>
    </div>
</div>
<form method="post" action="{{ route('profile.destroy') }}" id="deleteAccountForm">
    @csrf
    @method('delete')
    <div class="mb-4">
        <label for="delete_password" class="form-label fw-semibold">
            <i class="fas fa-lock text-primary me-2"></i>{{ __('common.confirm_with_password') }}
        </label>
        <input type="password"
               id="delete_password"
               name="password"
               class="form-control"
               placeholder="{{ __('common.enter_current_password') }}"
               required
               autocomplete="current-password">
        <div id="delete-password-error" class="invalid-feedback d-block mt-1" style="display:none;"></div>
    </div>
    <div class="d-flex justify-content-end">
        <button type="submit" class="btn btn-danger btn-lg px-4 fw-semibold shadow-sm" id="deleteAccountBtn">
            <i class="fas fa-trash me-2"></i>{{ __('common.delete_account_btn') }}
        </button>
    </div>
</form>

<!-- Custom Confirmation Dialog -->
<style>
#deleteConfirmDialog {
    display: none;
    position: fixed;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    z-index: 9999;
    background: none;
    pointer-events: none;
}
#deleteConfirmDialog.active {
    display: block;
    pointer-events: auto;
}
#deleteConfirmDialog .delete-dialog-box {
    background: #fff;
    border-radius: 18px;
    box-shadow: 0 8px 32px rgba(239,68,68,0.10);
    border: 1.5px solid #e5e7eb;
    max-width: 350px;
    width: 90vw;
    padding: 2rem 1.5rem;
    text-align: center;
    margin: 0;
}
</style>
<div id="deleteConfirmDialog">
    <div class="delete-dialog-box">
        <div class="mb-3">
            <div class="bg-danger text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width:48px; height:48px;">
                <i class="fas fa-exclamation-triangle" style="font-size:1.5rem;"></i>
            </div>
            <h5 class="fw-bold mb-2">{{ __('common.are_you_sure') }}</h5>
            <p class="mb-0">{{ __('common.are_you_sure_delete_account') }}</p>
        </div>
        <div class="d-flex justify-content-center gap-2 mt-4">
            <button id="cancelDeleteBtn" class="btn btn-secondary px-4" type="button">{{ __('common.cancel') }}</button>
            <button id="confirmDeleteBtn" class="btn btn-danger px-4" type="button">{{ __('common.yes_delete') }}</button>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('deleteAccountForm');
    const passwordInput = document.getElementById('delete_password');
    const dialog = document.getElementById('deleteConfirmDialog');
    const confirmBtn = document.getElementById('confirmDeleteBtn');
    const cancelBtn = document.getElementById('cancelDeleteBtn');
    const deleteBtn = document.getElementById('deleteAccountBtn');
    const errorDiv = document.getElementById('delete-password-error');
    let submitPending = false;

    form.addEventListener('submit', function(e) {
        if (submitPending) {
            submitPending = false;
            return;
        }
        e.preventDefault();
        errorDiv.style.display = 'none';
        errorDiv.textContent = '';
        passwordInput.classList.remove('is-invalid');
        deleteBtn.disabled = true;
        // AJAX check password
        fetch("{{ route('profile.check-password') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Accept': 'application/json',
            },
            body: JSON.stringify({ password: passwordInput.value })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                dialog.classList.add('active');
                confirmBtn.focus();
            } else {
                errorDiv.textContent = data.message || 'Incorrect password';
                errorDiv.style.display = 'block';
                passwordInput.classList.add('is-invalid');
            }
            deleteBtn.disabled = false;
        })
        .catch(() => {
            errorDiv.textContent = 'An error occurred. Please try again.';
            errorDiv.style.display = 'block';
            passwordInput.classList.add('is-invalid');
            deleteBtn.disabled = false;
        });
    });

    confirmBtn.addEventListener('click', function() {
        dialog.classList.remove('active');
        submitPending = true;
        deleteBtn.disabled = false;
        form.submit();
    });
    cancelBtn.addEventListener('click', function() {
        dialog.classList.remove('active');
        deleteBtn.disabled = false;
        setTimeout(function() {
            dialog.classList.remove('active');
        }, 100);
    });

    dialog.addEventListener('keydown', function(e) {
        if (e.key === 'Enter') {
            e.preventDefault();
        }
    });
});
</script>
