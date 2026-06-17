<script>
    window.initTaskTemplateByStage = function (options) {
        options = options || {};
        const selectedTemplateId = String(options.selectedTemplateId || '');
        const initialStageId = String(options.initialStageId || $('select[name="check_status_id"]').val() || '');
        const commentsSelector = options.commentsSelector || 'textarea[name="comments"]';
        let templateDescriptions = {};

        function escapeHtml(text) {
            return $('<div>').text(text ?? '').html();
        }

        function syncTemplateSelect2($templateSelect) {
            if ($templateSelect.attr('data-toggle') !== 'select2') {
                return;
            }
            if ($templateSelect.hasClass('select2-hidden-accessible')) {
                $templateSelect.trigger('change.select2');
            } else {
                $templateSelect.select2({ width: '100%' });
            }
        }

        function applyTemplateDescription(templateId, forceUpdate) {
            const $comments = $(commentsSelector);
            if (!$comments.length) {
                return;
            }

            if (!templateId) {
                if (forceUpdate) {
                    $comments.val('');
                }
                return;
            }

            const description = templateDescriptions[String(templateId)] || '';
            if (forceUpdate || !String($comments.val() || '').trim()) {
                $comments.val(description);
            }
        }

        function bindTemplateDescriptionHandler($templateSelect) {
            $templateSelect.off('change.taskTemplateDesc select2:select.taskTemplateDesc')
                .on('change.taskTemplateDesc select2:select.taskTemplateDesc', function () {
                    applyTemplateDescription(String($(this).val() || ''), true);
                });
        }

        function refreshTemplateSelect(checkStatusId, keepTemplateId) {
            const $templateSelect = $('select[name="template_id"]');

            if (!checkStatusId) {
                templateDescriptions = {};
                $templateSelect
                    .prop('disabled', true)
                    .empty()
                    .append('<option value="">請先選擇專案執行階段</option>');
                syncTemplateSelect2($templateSelect);
                applyTemplateDescription('', true);
                return;
            }

            $templateSelect
                .prop('disabled', true)
                .empty()
                .append('<option value="">載入中...</option>');
            syncTemplateSelect2($templateSelect);

            $.ajax({
                url: '/get-tasktemplate-id',
                method: 'GET',
                data: { check_status_id: checkStatusId },
                success: function (response) {
                    templateDescriptions = {};
                    $templateSelect.empty().append('<option value="">請選擇...</option>');

                    if (!response.length) {
                        $templateSelect.append('<option value="" disabled>此階段尚無派工項目</option>');
                    } else {
                        response.forEach(function (item) {
                            templateDescriptions[String(item.id)] = item.description || '';
                            const isSelected = String(keepTemplateId) === String(item.id);
                            $templateSelect.append(
                                '<option value="' + item.id + '"' + (isSelected ? ' selected' : '') + '>' +
                                escapeHtml(item.name) + '</option>'
                            );
                        });
                    }

                    $templateSelect.prop('disabled', false);
                    syncTemplateSelect2($templateSelect);
                    bindTemplateDescriptionHandler($templateSelect);

                    if (keepTemplateId) {
                        applyTemplateDescription(String(keepTemplateId), false);
                    }
                },
                error: function () {
                    templateDescriptions = {};
                    $templateSelect
                        .prop('disabled', true)
                        .empty()
                        .append('<option value="">無法載入派工項目</option>');
                    syncTemplateSelect2($templateSelect);
                    alert('無法加載資料，請稍後再試！');
                },
            });
        }

        $('select[name="check_status_id"]').off('change.taskTemplate select2:select.taskTemplate')
            .on('change.taskTemplate select2:select.taskTemplate', function () {
                refreshTemplateSelect(String($(this).val() || ''), '');
            });

        if (initialStageId) {
            refreshTemplateSelect(initialStageId, selectedTemplateId);
        } else {
            refreshTemplateSelect('', '');
        }
    };
</script>
