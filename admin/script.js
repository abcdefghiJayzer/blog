
function toggleSearch() {
    const searchBar = document.getElementById("mobileSearchBar");
    searchBar.classList.toggle("hidden");
}

function toggleMenu() {
    const menu = document.getElementById("mobileMenu");
    menu.classList.toggle("hidden");
}

function toggleDotsMenu(event) {
    event.stopPropagation();
    const dotsMenu = event.currentTarget.nextElementSibling;
    dotsMenu.classList.toggle("hidden");
}

function toggleUserMenu(event) {
    event.stopPropagation();
    const userMenu = event.currentTarget.nextElementSibling;
    userMenu.classList.toggle("hidden");
}

function toggleModal() {
    const modal = document.getElementById("commentsModal");
    modal.classList.toggle("hidden");
}

function toggleEditModal(event) {
    event.stopPropagation();
    const modal = document.getElementById("editModal");
    modal.classList.toggle("hidden");

    const dotsMenus = document.getElementsByClassName("dots-menu");
    for (let i = 0; i < dotsMenus.length; i++) {
        dotsMenus[i].classList.add("hidden");
    }
}

function togglePostModal() {
    const modal = document.getElementById("tweetModal");
    modal.classList.toggle("hidden");
    modal.classList.toggle("flex");
}

let isFilled = false;

function toggleHeart() {
    const heartIcon = document.getElementById("heart-icon");
    isFilled = !isFilled;

    if (isFilled) {
        heartIcon.classList.remove("far");
        heartIcon.classList.add("fas");
        heartIcon.classList.add("text-red-600");
    } else {
        heartIcon.classList.remove("fas");
        heartIcon.classList.add("far");
        heartIcon.classList.remove("text-red-600");
    }
}

function submitComment(event) {
    event.stopPropagation();
    const inputField = event.currentTarget.previousElementSibling;
    const commentsSection =
        event.currentTarget.closest(".comments-section");
    if (inputField.value) {
        const commentSection = document.createElement("div");
        commentSection.className = "flex items-start space-x-4 mt-4";
        commentSection.innerHTML = `
                        <div class="w-12 h-12">
                            <img class="w-full h-full rounded-md object-cover bg-neutral-500 aspect-square" src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcT0S5026V5d6dBD31uHzOi0hb-3lNFr3hwR_w&s" alt="" />
                        </div>
                        <div class="w-full">
                            <div class="flex justify-between">
                                <h6 class="font-semibold">Name</h6>
                                <small class="text-neutral-500">Just now</small>
                            </div>
                            <p class="text-3 mt-2">${inputField.value}</p>
                        </div>
                    `;
        commentsSection.appendChild(commentSection);
        inputField.value = "";
    }
}

window.onclick = function () {
    const dropdowns = document.getElementsByClassName("dots-menu");
    for (let i = 0; i < dropdowns.length; i++) {
        const openDropdown = dropdowns[i];
        openDropdown.classList.add("hidden");
    }
    const userMenus = document.getElementsByClassName("user-menu");
    for (let i = 0; i < userMenus.length; i++) {
        const openUserMenu = userMenus[i];
        openUserMenu.classList.add("hidden");
    }
};