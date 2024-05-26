const FILE_UPLOAD_FORM = document.querySelector('.file-upload-container form');
const FILE_LIST_CONTAINER = document.querySelector('.file-container');

function changeFormAction() {
    FILE_UPLOAD_FORM.action = FILE_UPLOAD_URL.replace(':categoryId', selectedCategoryId);
}

if (FILE_UPLOAD_FORM) {
    const fileUploadAjaxForm = new AjaxForm({
        form: FILE_UPLOAD_FORM,
        csrfToken: typeof CSRF_TOKEN !== 'undefined'? CSRF_TOKEN : null,
        submitCallback: changeFormAction,
    });

    fileUploadAjaxForm.listen();
}

if (FILE_LIST_CONTAINER) {
    FILE_LIST_CONTAINER.addEventListener('click', (e) => {
        if (e.target.tagName === 'SELECT') {
            const anchor = e.target.closest('.file-list').querySelector('a');
            const href = new URL(anchor.href);
    
            href.searchParams.set('version', e.target.value);
            anchor.href = href;
        }
    });
}