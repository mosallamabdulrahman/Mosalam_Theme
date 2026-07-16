/**
 * Admin-only script for the "project" post type edit screen: a live word
 * counter for the short description, and a WP Media-backed multi-image
 * gallery picker. Vanilla JS aside from wp.media, which is a Backbone/jQuery
 * app supplied by wp_enqueue_media() and has no plain JS equivalent.
 */
(function () {
  document.addEventListener('DOMContentLoaded', () => {
    initWordCounter();
    initGalleryPicker();
  });

  function initWordCounter() {
    const textarea = document.getElementById('mosalam_project_short_description');
    const counter = document.getElementById('mosalam_project_word_count');
    if (!textarea || !counter) return;

    const RECOMMENDED_MAX = 20;

    const update = () => {
      const words = textarea.value.trim().length ? textarea.value.trim().split(/\s+/) : [];
      const count = words.length;
      counter.textContent = `${count} word${count === 1 ? '' : 's'}`;
      counter.style.color = count > RECOMMENDED_MAX ? '#b32d2e' : '#646970';
    };

    textarea.addEventListener('input', update);
    update();
  }

  function initGalleryPicker() {
    const addButton = document.getElementById('mosalam-project-gallery-add');
    const preview = document.getElementById('mosalam-project-gallery-preview');
    const hiddenInput = document.getElementById('mosalam_project_gallery_ids');
    if (!addButton || !preview || !hiddenInput || typeof wp === 'undefined' || !wp.media) return;

    const getIds = () =>
      Array.from(preview.querySelectorAll('.mosalam-gallery-item')).map((el) => el.dataset.id);

    const syncHiddenInput = () => {
      hiddenInput.value = getIds().join(',');
    };

    const addThumbnail = (attachment) => {
      const item = document.createElement('div');
      item.className = 'mosalam-gallery-item';
      item.dataset.id = attachment.id;
      item.style.cssText = 'position:relative;width:100px;height:100px;';

      const img = document.createElement('img');
      img.src = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
      img.style.cssText = 'width:100%;height:100%;object-fit:cover;border:1px solid #dcdcde;border-radius:4px;';

      const removeBtn = document.createElement('button');
      removeBtn.type = 'button';
      removeBtn.className = 'mosalam-gallery-remove';
      removeBtn.textContent = '×';
      removeBtn.style.cssText =
        'position:absolute;top:-8px;right:-8px;width:22px;height:22px;line-height:20px;border-radius:50%;background:#a00;color:#fff;border:2px solid #fff;cursor:pointer;padding:0;';

      item.appendChild(img);
      item.appendChild(removeBtn);
      preview.appendChild(item);
    };

    let frame = null;
    addButton.addEventListener('click', (event) => {
      event.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: 'Select Gallery Images',
        button: { text: 'Add to Gallery' },
        multiple: true,
      });
      frame.on('select', () => {
        const selection = frame.state().get('selection');
        selection.each((attachment) => addThumbnail(attachment.toJSON()));
        syncHiddenInput();
      });
      frame.open();
    });

    preview.addEventListener('click', (event) => {
      const removeBtn = event.target.closest('.mosalam-gallery-remove');
      if (!removeBtn) return;
      removeBtn.closest('.mosalam-gallery-item').remove();
      syncHiddenInput();
    });
  }
})();
