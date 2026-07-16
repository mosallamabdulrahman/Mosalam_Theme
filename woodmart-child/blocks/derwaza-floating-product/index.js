import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, ColorPalette, TextareaControl, SelectControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
    <path d="M3 6h18" />
    <path d="M16 10a4 4 0 0 1-8 0" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { slides, autoplaySpeed } = attributes;
    const [activeSlideIndex, setActiveSlideIndex] = useState(0);

    const updateSlide = (index, key, value) => {
      const nextSlides = slides.map((slide, i) => {
        if (i === index) {
          return { ...slide, [key]: value };
        }
        return slide;
      });
      setAttributes({ slides: nextSlides });
    };

    const addSlide = () => {
      const newSlides = [
        ...slides,
        {
          eyebrow: '★ Featured Product',
          title: 'New Product Title',
          description: 'Product specifications and short features description go here.',
          price: '20.000 KD',
          oldPrice: '30.000 KD',
          discount: '33% OFF',
          buyLink: '#',
          detailsLink: '#',
          imageUrl: 'speaker-placeholder.png',
          bgColor: '#ffffff',
          textColor: '#1b1c1c'
        }
      ];
      setAttributes({ slides: newSlides });
      setActiveSlideIndex(newSlides.length - 1);
    };

    const removeSlide = (index) => {
      if (slides.length <= 1) return; // Keep at least one
      const nextSlides = slides.filter((_, i) => i !== index);
      setAttributes({ slides: nextSlides });
      setActiveSlideIndex((prev) => Math.max(0, Math.min(prev, nextSlides.length - 1)));
    };

    const moveSlide = (index, direction) => {
      if (direction === 'up' && index === 0) return;
      if (direction === 'down' && index === slides.length - 1) return;
      
      const targetIndex = direction === 'up' ? index - 1 : index + 1;
      const nextSlides = [...slides];
      const temp = nextSlides[index];
      nextSlides[index] = nextSlides[targetIndex];
      nextSlides[targetIndex] = temp;
      
      setAttributes({ slides: nextSlides });
      setActiveSlideIndex(targetIndex);
    };

    // Helper to resolve image paths
    const getImageUrl = (url) => {
      if (!url) return '';
      if (url.startsWith('http://') || url.startsWith('https://') || url.startsWith('data:') || url.startsWith('/')) {
        return url;
      }
      return window.mosalamThemeUrl ? `${window.mosalamThemeUrl}/assets/images/${url}` : url;
    };

    const activeSlide = slides[activeSlideIndex] || slides[0] || {};
    const slideBgColor = activeSlide.bgColor || '#ffffff';
    const slideTextColor = activeSlide.textColor || '#1b1c1c';

    const blockProps = useBlockProps({ 
      className: 'derwaza-floating-product-editor w-full py-4',
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title="Global Settings" initialOpen={true}>
            <div className="mb-5">
              <TextControl
                label="Autoplay Speed (ms)"
                type="number"
                value={autoplaySpeed}
                onChange={(val) => setAttributes({ autoplaySpeed: parseInt(val, 10) || 5000 })}
              />
            </div>
            <Button variant="primary" onClick={addSlide} className="w-full justify-center">
              + Add New Slide
            </Button>
          </PanelBody>

          <PanelBody title="Slide Content & Ordering" initialOpen={true}>
            {/* Slide Selector */}
            <div className="mb-5">
              <SelectControl
                label="Select Slide to Edit"
                value={activeSlideIndex.toString()}
                options={slides.map((slide, index) => ({
                  label: `Slide #${index + 1}: ${slide.title || 'Untitled'}`,
                  value: index.toString()
                }))}
                onChange={(value) => setActiveSlideIndex(parseInt(value, 10))}
              />
            </div>

            {/* Active Slide Actions */}
            <div className="flex flex-wrap gap-2 mb-6 pb-4 border-b border-gray-200">
              <Button 
                isSmall 
                variant="secondary" 
                onClick={() => moveSlide(activeSlideIndex, 'up')}
                disabled={activeSlideIndex === 0}
              >
                Move Up ↑
              </Button>
              <Button 
                isSmall 
                variant="secondary" 
                onClick={() => moveSlide(activeSlideIndex, 'down')}
                disabled={activeSlideIndex === slides.length - 1}
              >
                Move Down ↓
              </Button>
              <Button 
                isDestructive 
                isSmall 
                onClick={() => removeSlide(activeSlideIndex)}
                disabled={slides.length <= 1}
              >
                Delete Slide
              </Button>
            </div>

            {/* Fields */}
            {activeSlide && (
              <div className="active-slide-fields">
                <div className="mb-5">
                  <TextControl
                    label="Featured Badge (Eyebrow)"
                    value={activeSlide.eyebrow}
                    onChange={(value) => updateSlide(activeSlideIndex, 'eyebrow', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="Product Name (Title)"
                    value={activeSlide.title}
                    onChange={(value) => updateSlide(activeSlideIndex, 'title', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextareaControl
                    label="Specification Subtext (Description)"
                    value={activeSlide.description}
                    onChange={(value) => updateSlide(activeSlideIndex, 'description', value)}
                    rows={3}
                  />
                </div>

                <div className="grid grid-cols-2 gap-2 mb-5">
                  <TextControl
                    label="Sale Price"
                    value={activeSlide.price}
                    onChange={(value) => updateSlide(activeSlideIndex, 'price', value)}
                  />
                  <TextControl
                    label="Original Price"
                    value={activeSlide.oldPrice}
                    onChange={(value) => updateSlide(activeSlideIndex, 'oldPrice', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="Discount Text Badge"
                    value={activeSlide.discount}
                    onChange={(value) => updateSlide(activeSlideIndex, 'discount', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="Buy Now Link"
                    value={activeSlide.buyLink}
                    onChange={(value) => updateSlide(activeSlideIndex, 'buyLink', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="View Details Link"
                    value={activeSlide.detailsLink}
                    onChange={(value) => updateSlide(activeSlideIndex, 'detailsLink', value)}
                  />
                </div>

                <div className="mb-5">
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Product Image</span>
                  {activeSlide.imageUrl ? (
                    <div className="relative w-full h-32 mb-3 flex items-center justify-center overflow-hidden bg-gray-100 border rounded">
                      <img 
                        src={getImageUrl(activeSlide.imageUrl)} 
                        alt="Product preview" 
                        className="max-h-full object-contain"
                      />
                      <Button 
                        className="absolute bottom-2 right-2" 
                        isDestructive 
                        isSmall
                        onClick={() => updateSlide(activeSlideIndex, 'imageUrl', '')}
                      >
                        Remove Image
                      </Button>
                    </div>
                  ) : (
                    <div className="text-center py-4 mb-3 bg-gray-50 border border-dashed rounded">
                      <MediaUploadCheck>
                        <MediaUpload
                          onSelect={(media) => updateSlide(activeSlideIndex, 'imageUrl', media.url)}
                          allowedTypes={['image']}
                          render={({ open }) => (
                            <Button variant="secondary" isSmall onClick={open}>
                              Upload Image
                            </Button>
                          )}
                        />
                      </MediaUploadCheck>
                    </div>
                  )}
                  <TextControl
                    label="Or enter absolute image URL"
                    value={activeSlide.imageUrl}
                    onChange={(value) => updateSlide(activeSlideIndex, 'imageUrl', value)}
                  />
                </div>

                <div className="mb-5">
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Card Background Color</span>
                  <ColorPalette
                    colors={[
                      { name: 'White', color: '#ffffff' },
                      { name: 'Light Gray', color: '#f8fafc' },
                      { name: 'Light Amber', color: '#fffbeb' },
                      { name: 'Light Rose', color: '#fff1f2' }
                    ]}
                    value={activeSlide.bgColor}
                    onChange={(color) => updateSlide(activeSlideIndex, 'bgColor', color || '#ffffff')}
                  />
                </div>
              </div>
            )}
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          {/* Main Visual Render in Editor - overlaps slightly and matches white card theme */}
          <div className="max-w-[1100px] mx-auto">
            <div 
              className="relative rounded-[20px] overflow-hidden shadow-xl border border-gray-200/50 transition-all duration-500 ease-in-out"
              style={{ backgroundColor: slideBgColor, color: slideTextColor }}
            >
              <div className="flex flex-col md:flex-row items-center justify-between p-8 md:p-12 lg:p-14 gap-8">
                
                {/* Left Side: Product Info */}
                <div className="w-full md:w-1/2 flex flex-col items-start text-left z-10">
                  {activeSlide.eyebrow && (
                    <span className="text-xs font-bold text-amber-600 bg-amber-50 border border-amber-200/50 px-3 py-1.5 rounded-[6px] mb-4 uppercase font-sans tracking-wide">
                      {activeSlide.eyebrow}
                    </span>
                  )}
                  {activeSlide.title && (
                    <h3 className="text-2xl md:text-4xl font-bold leading-tight mb-3 m-0 font-sans text-gray-900">
                      {activeSlide.title}
                    </h3>
                  )}
                  {activeSlide.description && (
                    <p className="text-sm md:text-base text-gray-600 mb-6 m-0 font-sans leading-relaxed whitespace-pre-line">
                      {activeSlide.description}
                    </p>
                  )}

                  {/* Prices & Badges */}
                  <div className="flex items-center gap-3 mb-6">
                    {activeSlide.price && (
                      <span className="text-xl md:text-2xl font-bold text-gray-900 font-sans">
                        {activeSlide.price}
                      </span>
                    )}
                    {activeSlide.oldPrice && (
                      <span className="text-sm md:text-base line-through text-gray-400 font-sans">
                        {activeSlide.oldPrice}
                      </span>
                    )}
                    {activeSlide.discount && (
                      <span className="text-xs font-bold text-amber-700 bg-amber-100/70 border border-amber-200 px-2 py-0.5 rounded-[4px] font-sans">
                        {activeSlide.discount}
                      </span>
                    )}
                  </div>
                  
                  {/* Buttons */}
                  <div className="flex flex-wrap gap-4">
                    {activeSlide.buyLink && (
                      <span className="bg-[#8B5E3C] text-white px-8 py-3 rounded-full text-xs md:text-sm font-bold tracking-wide inline-flex items-center gap-2 font-sans select-none">
                        <span>Buy Now</span>
                      </span>
                    )}
                    {activeSlide.detailsLink && (
                      <span className="border border-gray-300 text-gray-700 hover:bg-gray-50 px-8 py-3 rounded-full text-xs md:text-sm font-bold tracking-wide inline-flex items-center gap-2 font-sans select-none">
                        <span>View Details</span>
                      </span>
                    )}
                  </div>
                </div>

                {/* Right Side: Image */}
                <div className="w-full md:w-1/2 flex items-center justify-center z-10 relative mt-4 md:mt-0">
                  {activeSlide.imageUrl ? (
                    <img 
                      src={getImageUrl(activeSlide.imageUrl)} 
                      alt={activeSlide.title} 
                      className="max-h-[200px] md:max-h-[280px] lg:max-h-[320px] object-contain drop-shadow-[0_15px_30px_rgba(0,0,0,0.1)]"
                    />
                  ) : (
                    <div className="w-60 h-60 rounded bg-gray-50 border border-dashed flex items-center justify-center text-gray-300">
                      <svg className="w-12 h-12" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="1.5">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                      </svg>
                    </div>
                  )}
                </div>

              </div>

              {/* Navigation Arrows */}
              <button 
                onClick={(e) => {
                  e.stopPropagation();
                  setActiveSlideIndex((prev) => (prev > 0 ? prev - 1 : slides.length - 1));
                }}
                className="derwaza-floating-swiper-prev absolute left-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full flex items-center justify-center transition-all duration-300 cursor-pointer select-none z-20 border border-gray-200"
                style={{ padding: 0 }}
              >
                <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                  <path d="m15 18-6-6 6-6" />
                </svg>
              </button>
              
              <button 
                onClick={(e) => {
                  e.stopPropagation();
                  setActiveSlideIndex((prev) => (prev < slides.length - 1 ? prev + 1 : 0));
                }}
                className="derwaza-floating-swiper-next absolute right-4 top-1/2 -translate-y-1/2 w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-800 rounded-full flex items-center justify-center transition-all duration-300 cursor-pointer select-none z-20 border border-gray-200"
                style={{ padding: 0 }}
              >
                <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                  <path d="m9 18 6-6-6-6" />
                </svg>
              </button>

              {/* Pagination Dots */}
              <div className="absolute bottom-5 left-0 right-0 flex justify-center z-20">
                {slides.map((_, i) => (
                  <button
                    key={i}
                    onClick={(e) => {
                      e.stopPropagation();
                      setActiveSlideIndex(i);
                    }}
                    className={`w-2 h-2 mx-1 transition-all duration-300 rounded-full border-none p-0 cursor-pointer ${
                      activeSlideIndex === i ? 'bg-gray-800 scale-125' : 'bg-gray-300'
                    }`}
                    style={{ outline: 'none' }}
                  />
                ))}
              </div>

            </div>
          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
