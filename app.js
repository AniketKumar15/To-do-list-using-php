// Get modal and buttons
const modal = document.getElementById("editModal");
const closeModal = document.querySelector(".close");
const editButtons = document.querySelectorAll(".edit-btn"); // All edit buttons
const editTaskInput = document.getElementById("editTaskInput");
const editPriorityRadios = document.getElementsByName("editPriority");
const editTaskId = document.getElementById("editTaskId");

// Function to show modal with task data
const openModal = (taskId, taskText, priority) => {
  modal.style.display = "flex"; // Show modal
  editTaskInput.value = taskText; // Set task text
  editTaskId.value = taskId; // Set hidden input with task ID

  // Select the correct priority radio button
  editPriorityRadios.forEach((radio) => {
    radio.checked = radio.value === priority;
  });
};

// Function to hide modal
const hideModal = () => {
  modal.style.display = "none"; // Hide modal
};

// Attach event listeners to all edit buttons
editButtons.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    const taskRow = e.target.closest("tr"); // Get parent row
    const taskId = taskRow.querySelector(".task-idReal").textContent.trim();
    const taskText = taskRow.querySelector(".task-text").textContent.trim();
    const priority = taskRow.querySelector(".priority-dot").dataset.priority;

    openModal(taskId, taskText, priority);
  });
});

// Close modal when clicking close button
closeModal.addEventListener("click", hideModal);


// Delete section
let deleteBtn = document.querySelectorAll(".delete-btn");
let deleteModal = document.getElementById("deleteModal");
let deleteTaskId = document.getElementById("deleteTaskId");
let closeDeleteModal = document.querySelector(".deleteClose");

const hideModalDelete = () => {
  deleteModal.style.display = "none"; // Hide modal
};
const openModalDelete = (taskId) => {
  deleteModal.style.display = "flex"; // Show modal
  deleteTaskId.value = taskId; // Set hidden input with task ID
};

deleteBtn.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    const taskRow = e.target.closest("tr"); // Get parent row
    const taskId = taskRow.querySelector(".task-idReal").textContent.trim();

    openModalDelete(taskId);
  });
});
closeDeleteModal.addEventListener("click", hideModalDelete)
// Close modal when clicking outside the modal content
window.addEventListener("click", (event) => {
  if (event.target === modal) {
    hideModal();
  }
  if (event.target === deleteModal) {
    hideModalDelete();
  }
});

// Done modal Section
let doneCheckBox = document.querySelectorAll(".isDoneBox");
let doneModal = document.getElementById("doneModal");
let doneTaskId = document.getElementById("doneTaskId");
let closeDoneModal = document.querySelector(".doneClose");
let confirmDoneBtn = document.getElementById("confirmDone"); // "Yes" button
let currentCheckbox = null; // Store the clicked checkbox

const hideModalDone = () => {
  doneModal.style.display = "none"; // Hide modal
  //If modal is closed without confirmation, uncheck the box
  if (currentCheckbox) {
    currentCheckbox.checked = false;
  }
};
const openModalDone = (checkbox, taskId) => {
  doneModal.style.display = "flex"; // Show modal
  doneTaskId.value = taskId; // Set hidden input with task ID
  currentCheckbox = checkbox;
};

doneCheckBox.forEach((btn) => {
  if (btn.checked) {
    btn.disabled = true; // Disable if already checked
  }
});

doneCheckBox.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    //btn.disabled = true; // Disable the clicked checkbox
    const taskRow = e.target.closest("tr"); // Get parent row
    const taskId = taskRow.querySelector(".task-idReal").textContent.trim();

    openModalDone(btn, taskId);
  });
});

confirmDoneBtn.addEventListener("click", () => {
  if (currentCheckbox) {
    currentCheckbox.checked = true; // Keep it checked
    currentCheckbox.disabled = true; // Disable after checking
  }
  hideModalDone();
});
closeDoneModal.addEventListener("click", hideModalDone);
