
document.getElementById('file-upload').addEventListener('change', function(event) {
    var fileName = event.target.files[0].name;
    // Ищем наш label и меняем его текст
    document.querySelector('.custom-file-upload').innerText = fileName;
    // Можно добавить иконку обратно или другие действия
});