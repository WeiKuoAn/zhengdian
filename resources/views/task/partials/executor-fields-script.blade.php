<style>
    .executor-entry .select2-container {
        width: 100% !important;
    }

    .executor-entry label {
        padding-left: 0;
        margin-left: 0;
    }

    .executor-entry .form-control {
        margin-left: 0;
    }
</style>
<script>
    window.buildExecutorEntryHtml = function (contextRequired) {
        const requiredAttr = contextRequired ? ' required' : '';

        return `
<div class="executor-entry border rounded p-3 mb-3 bg-light">
    <div class="d-flex justify-content-end mb-2">
        <button type="button" class="btn btn-danger btn-sm remove-executor" aria-label="移除執行人員">
            <i class="mdi mdi-trash-can-outline"></i>
        </button>
    </div>
    <div class="mb-3">
        <label class="d-block small text-muted mb-1">執行人員</label>
        <select class="form-control w-100" data-toggle="select" data-width="100%" name="user_ids[]" required>
            @foreach ($users as $user)
            <option value="{{ $user->id }}">{{ $user->name }}</option>
            @endforeach
            <option value="">無</option>
        </select>
    </div>
    <div>
        <label class="d-block small text-muted mb-1">派工項目</label>
        <textarea class="form-control w-100 executor-context-input" name="contexts[]" rows="4" placeholder="派工項目（選派工項目後自動帶入項目名稱，可修改）"${requiredAttr}></textarea>
    </div>
</div>`;
    };

    window.bindExecutorFields = function (options) {
        options = options || {};
        const buttonSelector = options.buttonSelector || '#add-executor';
        const containerSelector = options.containerSelector || '#executor-container';
        const contextRequired = !!options.contextRequired;

        $(buttonSelector).off('click.executorFields').on('click.executorFields', function () {
            $(containerSelector).append(window.buildExecutorEntryHtml(contextRequired));
            const contextValue = typeof window.getSelectedTaskTemplateName === 'function'
                ? window.getSelectedTaskTemplateName()
                : (typeof window.getSelectedTaskTemplateDescription === 'function'
                    ? window.getSelectedTaskTemplateDescription()
                    : '');
            if (contextValue) {
                $(containerSelector + ' .executor-entry').last().find('textarea[name="contexts[]"]').val(contextValue);
            }
        });

        $(document).off('click.removeExecutor').on('click.removeExecutor', '.remove-executor', function () {
            const $container = $(this).closest('#executor-container, #editExecutorContainer, #copyExecutorContainer');
            if ($container.find('.executor-entry').length > 1) {
                $(this).closest('.executor-entry').remove();
            }
        });
    };
</script>
