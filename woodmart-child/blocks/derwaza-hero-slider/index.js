import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, ColorPalette, TextareaControl, SelectControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <rect width="18" height="18" x="3" y="3" rx="2" />
    <path d="m8 12 4 4 6-6" />
    <path d="M12 8v4" />
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
          eyebrow: 'New Product',
          title: 'Product Headline goes here',
          btnText: 'Shop Now',
          btnLink: '#',
          imageUrl: 'iphone-placeholder.png',
          bgColor: '#1a1a15',
          textColor: '#ffffff'
        }
      ];
      setAttributes({ slides: newSlides });
      setActiveSlideIndex(newSlides.length - 1);
    };

    const removeSlide = (index) => {
      if (slides.length <= 1) return; // Keep at least one slide
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
    const slideBgColor = activeSlide.bgColor || '#1a1a15';
    const slideTextColor = activeSlide.textColor || '#ffffff';

    const blockProps = useBlockProps({ 
      className: 'derwaza-slider-editor w-full relative rounded-b-[20px] overflow-hidden shadow-lg transition-all duration-500 ease-in-out',
      style: { backgroundColor: slideBgColor, color: slideTextColor }
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
            {/* Slide Selector Dropdown */}
            <div className="mb-5">
              <SelectControl
                label="Select Slide to Edit"
                value={activeSlideIndex.toString()}
                options={slides.map((slide, index) => ({
                  label: `Slide #${index + 1}: ${slide.eyebrow || 'Untitled'}`,
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

            {/* Editing fields for the active slide */}
            {activeSlide && (
              <div className="active-slide-fields">
                <div className="mb-5">
                  <TextControl
                    label="Eyebrow"
                    value={activeSlide.eyebrow}
                    onChange={(value) => updateSlide(activeSlideIndex, 'eyebrow', value)}
                  />
                </div>
                
                <div className="mb-5">
                  <TextareaControl
                    label="Title"
                    value={activeSlide.title}
                    onChange={(value) => updateSlide(activeSlideIndex, 'title', value)}
                    rows={2}
                  />
                </div>
                
                <div className="mb-5">
                  <TextControl
                    label="Button Label"
                    value={activeSlide.btnText}
                    onChange={(value) => updateSlide(activeSlideIndex, 'btnText', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="Button Link"
                    value={activeSlide.btnLink}
                    onChange={(value) => updateSlide(activeSlideIndex, 'btnLink', value)}
                  />
                </div>

                <div className="mb-5">
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Slide Image</span>
                  {activeSlide.imageUrl ? (
                    <div className="relative w-full h-32 mb-3 flex items-center justify-center overflow-hidden bg-gray-950 border rounded">
                      <img 
                        src={getImageUrl(activeSlide.imageUrl)} 
                        alt="Slide preview" 
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
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Background Color</span>
                  <ColorPalette
                    colors={[
                      { name: 'Dark Brown', color: '#1a1a15' },
                      { name: 'Dark Charcoal', color: '#211c18' },
                      { name: 'Dark Navy', color: '#0f172a' },
                      { name: 'Dark Forest', color: '#064e3b' }
                    ]}
                    value={activeSlide.bgColor}
                    onChange={(color) => updateSlide(activeSlideIndex, 'bgColor', color || '#1a1a15')}
                  />
                </div>
              </div>
            )}
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          {/* Main Visual Render in Editor */}
          <div className="relative overflow-hidden flex items-center min-h-[280px] md:min-h-[360px] lg:min-h-[420px] px-6 py-8 md:px-16 md:py-12 lg:px-24 lg:py-16">
            
            {/* Cover Background Image */}
            {activeSlide.imageUrl ? (
              <>
                <img 
                  src={getImageUrl(activeSlide.imageUrl)} 
                  alt={activeSlide.title} 
                  className="absolute inset-0 w-full h-full object-cover object-center z-0"
                />
                {/* Gradient Overlay for Legibility */}
                <div className="absolute inset-0 bg-gradient-to-r from-black/85 via-black/45 to-transparent z-10"></div>
              </>
            ) : (
              <div className="absolute inset-0 bg-gradient-to-tr from-black/30 to-black/5 z-0"></div>
            )}
            
            {/* Content Container */}
            <div className="w-full max-w-4xl flex flex-col items-start text-left z-20 relative">
              {activeSlide.eyebrow && (
                <span className="text-xs md:text-sm font-semibold tracking-wider text-amber-500 mb-3 uppercase font-sans">
                  {activeSlide.eyebrow}
                </span>
              )}
              {activeSlide.title && (
                <h2 className="text-2xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6 m-0 font-sans text-white">
                  {activeSlide.title}
                </h2>
              )}
              {activeSlide.btnText && (
                <span className="bg-[#8B5E3C] text-white px-8 py-3.5 rounded-full text-xs md:text-sm font-bold tracking-wide inline-flex items-center gap-2 mt-2 font-sans select-none">
                  <span>{activeSlide.btnText}</span>
                  <svg className="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2.5">
                    <path d="M5 12h14M12 5l7 7-7 7" />
                  </svg>
                </span>
              )}
            </div>

          </div>

          {/* Navigation Arrows */}
          <button 
            onClick={(e) => {
              e.stopPropagation();
              setActiveSlideIndex((prev) => (prev > 0 ? prev - 1 : slides.length - 1));
            }}
            className="derwaza-swiper-btn-prev absolute left-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-md cursor-pointer select-none z-20 border border-white/10"
            style={{ border: '1px solid rgba(255,255,255,0.1)', padding: 0 }}
          >
            <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="m15 18-6-6 6-6" />
            </svg>
          </button>
          
          <button 
            onClick={(e) => {
              e.stopPropagation();
              setActiveSlideIndex((prev) => (prev < slides.length - 1 ? prev + 1 : 0));
            }}
            className="derwaza-swiper-btn-next absolute right-6 top-1/2 -translate-y-1/2 w-11 h-11 bg-white/10 hover:bg-white/20 text-white rounded-full flex items-center justify-center transition-all duration-300 backdrop-blur-md cursor-pointer select-none z-20 border border-white/10"
            style={{ border: '1px solid rgba(255,255,255,0.1)', padding: 0 }}
          >
            <svg className="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
              <path d="m9 18 6-6-6-6" />
            </svg>
          </button>

          {/* Pagination Dots */}
          <div className="absolute bottom-6 left-0 right-0 flex justify-center z-20">
            {slides.map((_, i) => (
              <button
                key={i}
                onClick={(e) => {
                  e.stopPropagation();
                  setActiveSlideIndex(i);
                }}
                className={`w-2 h-2 mx-1.5 transition-all duration-300 rounded-full border-none p-0 cursor-pointer ${
                  activeSlideIndex === i ? 'bg-white scale-125' : 'bg-white/35'
                }`}
                style={{ outline: 'none' }}
              />
            ))}
          </div>

        </div>
      </>
    );
  },
  save: () => null,
});
