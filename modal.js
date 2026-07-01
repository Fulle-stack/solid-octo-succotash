// Функция открытия модального окна редактирования
function openEditModal(studentId) {
    // Показать индикатор загрузки
    document.getElementById('editModal').style.display = 'block';
    
    // Очистить предыдущие ошибки
    clearErrors();
    
    // Загрузить данные студента через AJAX
    fetch('index.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({
            'action': 'get_student',
            'id': studentId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Заполнить форму данными студента
            document.getElementById('editStudentId').value = data.student.id;
            document.getElementById('editFullName').value = data.student.full_name;
            document.getElementById('editEmail').value = data.student.email;
            document.getElementById('editGroup').value = data.student.group_name;
            document.getElementById('editCourse').value = data.student.course;
        } else {
            alert('Ошибка загрузки данных: ' + data.error);
            closeEditModal();
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка загрузки данных');
        closeEditModal();
    });
}

// Функция закрытия модального окна
function closeEditModal() {
    document.getElementById('editModal').style.display = 'none';
    clearErrors();
}

// Очистка сообщений об ошибках
function clearErrors() {
    document.getElementById('errorFullName').textContent = '';
    document.getElementById('errorEmail').textContent = '';
    document.getElementById('errorGroup').textContent = '';
    document.getElementById('errorCourse').textContent = '';
    document.getElementById('errorCommon').textContent = '';
}

// Обработчик отправки формы редактирования
document.getElementById('editForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Собрать данные формы
    const formData = new FormData(this);
    formData.append('action', 'update_student');
    
    // Очистить ошибки
    clearErrors();
    
    // Отправить данные через AJAX
    fetch('index.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Успешное обновление - перезагрузить страницу
            location.reload();
        } else {
            // Показать ошибки валидации
            if (data.errors) {
                if (data.errors.full_name) {
                    document.getElementById('errorFullName').textContent = data.errors.full_name;
                }
                if (data.errors.email) {
                    document.getElementById('errorEmail').textContent = data.errors.email;
                }
                if (data.errors.group_name) {
                    document.getElementById('errorGroup').textContent = data.errors.group_name;
                }
                if (data.errors.course) {
                    document.getElementById('errorCourse').textContent = data.errors.course;
                }
                if (data.errors.common) {
                    document.getElementById('errorCommon').textContent = data.errors.common;
                }
            }
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Ошибка при обновлении данных');
    });
});

// Функции для открытия/закрытия модального окна
function openDebtModal() {
    document.getElementById('debtModal').style.display = 'block';
}

function closeDebtModal() {
    document.getElementById('debtModal').style.display = 'none';
}

// Закрытие при клике вне окна
window.onclick = function(event) {
    const modal = document.getElementById('debtModal');
    if (event.target == modal) {
        closeDebtModal();
    }
}