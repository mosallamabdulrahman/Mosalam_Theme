/**
 * Admin-only script for the "project" post type and "project_category" taxonomy edit screens:
 * live word counter for the short description, single logo image picker, and category hero background picker.
 */
(function () {
  document.addEventListener('DOMContentLoaded', () => {
    initWordCounter();
    initLogoPicker();
    initCategoryBgPicker();
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

  function initLogoPicker() {
    const uploadBtn = document.getElementById('mosalam-logo-upload-btn');
    const removeBtn = document.getElementById('mosalam-logo-remove-btn');
    const preview = document.getElementById('mosalam-logo-preview');
    const hiddenInput = document.getElementById('mosalam_project_logo_id');
    if (!uploadBtn || !removeBtn || !preview || !hiddenInput || typeof wp === 'undefined' || !wp.media) return;

    let frame = null;

    uploadBtn.addEventListener('click', (event) => {
      event.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: 'Choose Project Logo',
        button: { text: 'Use this Image' },
        multiple: false
      });
      frame.on('select', () => {
        const attachment = frame.state().get('selection').first().toJSON();
        hiddenInput.value = attachment.id;
        
        const imgUrl = (attachment.sizes && attachment.sizes.thumbnail) ? attachment.sizes.thumbnail.url : attachment.url;
        let img = preview.querySelector('img');
        if (!img) {
          img = document.createElement('img');
          img.style.cssText = 'max-width:150px;height:auto;border:1px solid #dcdcde;border-radius:4px;padding:4px;background:#fff;display:block;';
          preview.appendChild(img);
        }
        img.src = imgUrl;
        preview.style.display = 'block';
        removeBtn.style.display = 'inline-block';
      });
      frame.open();
    });

    removeBtn.addEventListener('click', (event) => {
      event.preventDefault();
      hiddenInput.value = '';
      preview.style.display = 'none';
      removeBtn.style.display = 'none';
      const img = preview.querySelector('img');
      if (img) img.src = '';
    });
  }

  function initCategoryBgPicker() {
    const uploadBtn = document.getElementById('mosalam-cat-bg-upload-btn');
    const removeBtn = document.getElementById('mosalam-cat-bg-remove-btn');
    const preview = document.getElementById('mosalam-cat-bg-preview');
    const hiddenInput = document.getElementById('mosalam_category_hero_bg_id');
    if (!uploadBtn || !removeBtn || !preview || !hiddenInput || typeof wp === 'undefined' || !wp.media) return;

    let frame = null;

    uploadBtn.addEventListener('click', (event) => {
      event.preventDefault();
      if (frame) {
        frame.open();
        return;
      }
      frame = wp.media({
        title: 'Choose Hero Background Image',
        button: { text: 'Use this Image' },
        multiple: false
      });
      frame.on('select', () => {
        const attachment = frame.state().get('selection').first().toJSON();
        hiddenInput.value = attachment.id;
        
        const imgUrl = (attachment.sizes && attachment.sizes.large) ? attachment.sizes.large.url : attachment.url;
        let img = preview.querySelector('img');
        if (!img) {
          img = document.createElement('img');
          img.style.cssText = 'max-width:200px;height:auto;border:1px solid #dcdcde;border-radius:4px;padding:4px;background:#fff;display:block;';
          preview.appendChild(img);
        }
        img.src = imgUrl;
        preview.style.display = 'block';
        removeBtn.style.display = 'inline-block';
      });
      frame.open();
    });

    removeBtn.addEventListener('click', (event) => {
      event.preventDefault();
      hiddenInput.value = '';
      preview.style.display = 'none';
      removeBtn.style.display = 'none';
      const img = preview.querySelector('img');
      if (img) img.src = '';
    });
  }
})();
