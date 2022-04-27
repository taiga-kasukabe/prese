const modalWrapOpen = function(e) {
  const dataModalOpen = e.currentTarget.dataset.modalOpen;
  Array.from(document.querySelectorAll('.works_modal_wrapper')).forEach((e, i) => {
    if(e.getAttribute('data-modal') === dataModalOpen){
      e.classList.toggle('is_open');
    }
  })
}

Array.from(document.querySelectorAll('.works_modal_open')).forEach((modalOpenElement) => {
  modalOpenElement.addEventListener('click', modalWrapOpen);
})

const modalCloseAction = function(e) {
  const targetModal = e.currentTarget.closest('.works_modal_wrapper');
  targetModal.classList.toggle('is_open')
};

Array.from(document.querySelectorAll('.works_modal_close')).forEach((modalCloseElement) => {
  modalCloseElement.addEventListener('click', modalCloseAction)
})