class Todo {
    constructor() {
        this.tasks = JSON.parse(localStorage.getItem('todoTasks')) || [];
        this.term = "";
        this.root = document.getElementById('todo-list-root');
        this.init();
    }

    init() {
        document.getElementById('add-btn').addEventListener('click', () => this.addTask());
        document.getElementById('search-input').addEventListener('input', (e) => {
            this.term = e.target.value;
            this.draw();
        });
        this.draw();
    }

    save() {
        localStorage.setItem('todoTasks', JSON.stringify(this.tasks));
    }

    addTask() {
        const nameInput = document.getElementById('new-task-name');
        const dateInput = document.getElementById('new-task-date');
        const name = nameInput.value.trim();
        const date = dateInput.value;

        const today = new Date().toISOString().split('T')[0];
        if (name.length < 3 || name.length > 255) {
            alert("Nazwa musi mieć od 3 do 255 znaków.");
            return;
        }
        if (date !== "" && date < today) {
            alert("Data nie może być z przeszłości.");
            return;
        }

        this.tasks.push({ id: Date.now(), name, date, completed: false });
        nameInput.value = "";
        dateInput.value = "";
        this.save();
        this.draw();
    }

    toggleComplete(id) {
        const task = this.tasks.find(t => t.id === id);
        if (task) {
            task.completed = !task.completed;
            this.save();
            this.draw();
        }
    }

    deleteTask(id) {
        this.tasks = this.tasks.filter(t => t.id !== id);
        this.save();
        this.draw();
    }

    updateTask(id, newName, newDate) {
        const task = this.tasks.find(t => t.id === id);
        if (task) {
            task.name = newName;
            task.date = newDate;
            this.save();
            this.draw();
        }
    }

    get filteredTasks() {
        if (this.term.length < 2) return this.tasks;
        return this.tasks.filter(t => t.name.toLowerCase().includes(this.term.toLowerCase()));
    }

    highlightText(text) {
        if (this.term.length < 2) return text;
        const re = new RegExp(`(${this.term})`, 'gi');
        return text.replace(re, '<span class="highlight">$1</span>');
    }

    draw() {
        this.root.innerHTML = "";
        this.filteredTasks.forEach(task => {
            const div = document.createElement('div');
            div.className = 'todo-item';
            
            div.innerHTML = `
                <input type="checkbox" class="task-checkbox" ${task.completed ? 'checked' : ''}>
                <div class="task-info" style="display: flex; flex-grow: 1; align-items: center; cursor: pointer;">
                    <span class="task-text ${task.completed ? 'completed-text' : ''}">${this.highlightText(task.name)}</span>
                    <span class="task-date">${task.date}</span>
                </div>
                <button class="delete-btn" ${!task.completed ? 'disabled' : ''}>Usuń</button>
            `;

            div.querySelector('.task-checkbox').addEventListener('click', (e) => {
                e.stopPropagation();
                this.toggleComplete(task.id);
            });

            div.querySelector('.delete-btn').addEventListener('click', (e) => {
                e.stopPropagation();
                this.deleteTask(task.id);
            });

            div.querySelector('.task-info').addEventListener('click', () => this.renderEditMode(div, task));

            this.root.appendChild(div);
        });
    }

    renderEditMode(container, task) {
        container.onclick = (e) => e.stopPropagation();

        container.innerHTML = `
            <input type="text" class="edit-name" value="${task.name}" style="flex-grow: 1;">
            <input type="date" class="edit-date" value="${task.date}">
        `;
        
        const inputName = container.querySelector('.edit-name');
        const inputDate = container.querySelector('.edit-date');
        inputName.focus();

        const saveEdit = () => {
            const newName = inputName.value;
            const newDate = inputDate.value;
            if (newName.length >= 3 && newName.length <= 255) {
                this.updateTask(task.id, newName, newDate);
            } else {
                this.draw();
            }
            window.removeEventListener('click', handleOutsideClick);
        };

        const handleOutsideClick = (e) => {
            if (!container.contains(e.target)) {
                saveEdit();
            }
        };

        setTimeout(() => {
            window.addEventListener('click', handleOutsideClick);
        }, 0);

        container.addEventListener('keyup', (e) => {
            if (e.key === 'Enter') saveEdit();
        });
    }
}

const myTodo = new Todo();