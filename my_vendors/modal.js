//elements
var body = document.body;
var buttons = document.querySelectorAll(".open-modal");
var images = document.querySelectorAll(".open-image");


buttons.forEach(button => {
    button.addEventListener('click', () => {
        var modal_id = "#".concat(button.dataset.modalId);
        var modal = document.querySelector(modal_id);
        var popup = modal.querySelector(".my_popup");
        toggle();
        var close = document.createElement('button');
        close.classList = "close";
        close.innerHTML = "&times;";
        popup.insertBefore(close, popup.childNodes[0]);

        popup.classList.add("has-scrollbar");
        var span = popup.getElementsByClassName("close")[0];
        span.onclick = function () {
            toggle();
        };
        window.onclick = function (event) {
            if (event.target == modal) {
                toggle();
            }
        };
        function toggle() {
            body.classList.toggle('active');
            modal.classList.toggle('active');
            popup.classList.toggle('active');
        }
    });
});


images.forEach(image => {
    var img = image.firstElementChild;
    var type = img.tagName;
    type = type.toLowerCase();

    var modal = document.createElement('div');
    modal.classList = "custom-modal gallery";

    var extra_classes = image.classList.value;
    if (extra_classes !== 'open-image') {
        extra_classes = extra_classes.replace("open-image ", "");
        modal.classList.add(extra_classes);
    }

    var popup = document.createElement('div');
    popup.classList = "popup";
    var photo = document.createElement(type);
    photo.classList = "modal-".concat(type);
    photo.src = img.src;
    if (type == 'img') {
        photo.alt = img.alt;
    }
    if (type == 'video') {
        photo.setAttribute("controls", "controls");
    }

    popup.appendChild(photo);
    modal.appendChild(popup);
    document.body.appendChild(modal);
    image.addEventListener('click', () => {
        event.preventDefault()
        toggle();
        var close = document.createElement('button');
        close.classList = "close";
        close.innerHTML = "&times;";
        popup.insertBefore(close, popup.childNodes[0]);

        popup.classList.add("has-scrollbar");
        var span = popup.getElementsByClassName("close")[0];
        span.onclick = function () {
            toggle();
        };
        window.onclick = function (event) {
            if (event.target == modal) {
                toggle();
            }
        };
    });
    function toggle() {
        body.classList.toggle('active');
        modal.classList.toggle('active');
        popup.classList.toggle('active');
    }
});     