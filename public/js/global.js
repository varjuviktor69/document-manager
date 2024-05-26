async function getFilesByCategory() {
        try {
        const response = await fetch(FILE_BY_CATEGORY_ROUTE.replace(':categoryId', selectedCategoryId));

        if (!response.ok) {
            throw Error('Failed to get files!');
        }

        const json = await response.json();

        const fileContainer = document.querySelector('.file-container');

        fileContainer.insertAdjacentHTML('beforebegin', json);
        fileContainer.remove();
    } catch(error) {
        console.error(error);
    }
}