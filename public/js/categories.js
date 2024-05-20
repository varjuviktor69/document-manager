const SELECTED_CATEGORY_EL = document.querySelector('.selected-category');
const EDIT_FORM_EL = document.querySelector('.edit-form form');
const CREATE_FORM_EL = document.querySelector('.create-form form');

let selectedCategoryId = DEFAULT_CATEGORY.id;

CREATE_FORM_EL.action = CREATE_ROUTE.replace(':parentId', DEFAULT_CATEGORY.id);
EDIT_FORM_EL.action = EDIT_ROUTE.replace(':id', DEFAULT_CATEGORY.id);

function handleOpenAndCloseCategories() {
    document.querySelector('.categories-container li').addEventListener('click', (e) => {
        if (e.target === e.target.closest('li')) {
            const clickedLi = e.target;
            const childLis = [...clickedLi.parentElement.querySelectorAll(`li[data-category-slug=${clickedLi.dataset.categorySlug}] > ul > li`)];

            selectedCategoryId = e.target.dataset.id;
            SELECTED_CATEGORY_EL.textContent =  'Selected category: ' + e.target.dataset.name;

            const closeEl = clickedLi.querySelector('.close-indicator');
            const openEl = clickedLi.querySelector('.open-indicator');

            if (closeEl && openEl) {
                clickedLi.querySelector('.close-indicator').classList.toggle('hidden');
                clickedLi.querySelector('.open-indicator').classList.toggle('hidden');
            }

            childLis.forEach((childLi) => {
                childLi.classList.toggle('hidden');
            });

            CREATE_FORM_EL.action = CREATE_ROUTE.replace(':parentId', selectedCategoryId);
            EDIT_FORM_EL.action = EDIT_ROUTE.replace(':id', selectedCategoryId);
        }
    });
}

function createCategoryTree(subCategories) {
    const parentUl = [...document.querySelectorAll('.categories-list')].pop();

    for (const subCategory of subCategories.sub_categories) {
        const childLi = document.createElement('li');

        childLi.innerHTML = subCategory.name;
        childLi.dataset.categorySlug = subCategory.slug;
        childLi.dataset.id = subCategory.id;
        childLi.dataset.name = subCategory.name;

        childLi.classList.add('hidden');

        if (subCategory.sub_categories) {
            if (subCategory.sub_categories.length) {
                childLi.innerHTML += '<span class="open-indicator">&#9655</span>';
                childLi.innerHTML += '<span class="close-indicator hidden">&#9661;</span>';
            }

            const childUl = document.createElement('ul');

            childUl.className = 'categories-list';
            childLi.appendChild(childUl);
            parentUl.appendChild(childLi);

            createCategoryTree(subCategory);
        }
    }
}

async function deleteCategory(id) {
    const route = DELETE_ROUTE.replace(':id', id);

    try {
        const response = await fetch(route, {
            method: 'DELETE',
            headers: {
                "X-CSRF-Token": CSRF_TOKEN,
            },
        });

        if (!response.ok) {
            throw new Error('Failed to delete category!');
        } else {
            window.location.reload();
        }
    } catch (error) {
        alert(error);
    }
}

function handleButtons() {
    document.querySelector('.delete-btn').addEventListener('click', (e) => {
        e.preventDefault();
    
        deleteCategory(selectedCategoryId);
    });

    document.querySelector('.edit-btn').addEventListener('click', (e) => {
        e.preventDefault();
    
        document.querySelector('.edit-form').classList.remove('hidden');
        document.querySelector('.create-form').classList.add('hidden');
    });

    document.querySelector('.create-btn').addEventListener('click', (e) => {
        e.preventDefault();
    
        document.querySelector('.create-form').classList.remove('hidden');
        document.querySelector('.edit-form').classList.add('hidden');
    });
}

// TODO: handle all forms with ajax