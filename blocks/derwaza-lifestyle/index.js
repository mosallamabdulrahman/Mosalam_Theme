import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, SelectControl, ColorPalette } from '@wordpress/components';
import { useState } from '@wordpress/element';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { sectionTitle, items } = attributes;
    const [activeItemIndex, setActiveItemIndex] = useState(0);

    const blockProps = useBlockProps({
      className: 'derwaza-lifestyle-editor w-full max-w-[1400px] mx-auto py-6 px-4 md:px-6',
    });

    const updateItem = (index, key, value) => {
      const nextItems = items.map((item, i) => {
        if (i === index) {
          return { ...item, [key]: value };
        }
        return item;
      });
      setAttributes({ items: nextItems });
    };

    const themeUrl = window.mosalamThemeUrl || '';
    const defImages = [
      themeUrl + '/assets/images/portfolio/life-travel.png',
      themeUrl + '/assets/images/portfolio/life-office.png',
      themeUrl + '/assets/images/portfolio/life-fitness.png',
      themeUrl + '/assets/images/portfolio/life-smart.png',
      themeUrl + '/assets/images/portfolio/life-car.png'
    ];

    const activeItem = items[activeItemIndex] || items[0] || {};

    return (
      <>
        <InspectorControls>
          <PanelBody title="Section Header Settings" initialOpen={true}>
            <TextControl
              label="Section Title"
              value={sectionTitle}
              onChange={(val) => setAttributes({ sectionTitle: val })}
            />
          </PanelBody>

          <PanelBody title="Lifestyle Card Settings" initialOpen={true}>
            <SelectControl
              label="Select Card to Edit"
              value={activeItemIndex.toString()}
              options={items.map((item, idx) => ({
                label: `Card #${idx + 1}: ${item.title || 'Untitled'}`,
                value: idx.toString()
              }))}
              onChange={(val) => setActiveItemIndex(parseInt(val, 10))}
            />

            {activeItem && (
              <div style={{ marginTop: '16px', borderTop: '1px solid #e2e8f0', paddingTop: '16px' }}>
                <TextControl
                  label="Card Title"
                  value={activeItem.title}
                  onChange={(val) => updateItem(activeItemIndex, 'title', val)}
                />
                
                <div style={{ display: 'flex', gap: '8px' }}>
                  <div style={{ flex: 1 }}>
                    <TextControl
                      label="Link Label"
                      value={activeItem.linkLabel}
                      onChange={(val) => updateItem(activeItemIndex, 'linkLabel', val)}
                    />
                  </div>
                  <div style={{ flex: 2 }}>
                    <TextControl
                      label="Link URL"
                      value={activeItem.linkUrl}
                      onChange={(val) => updateItem(activeItemIndex, 'linkUrl', val)}
                    />
                  </div>
                </div>

                <div className="mb-4">
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Bottom Strip Background Color</span>
                  <ColorPalette
                    colors={[
                      { name: 'Peach', color: '#f4eae1' },
                      { name: 'Soft Blue', color: '#e6ecf4' },
                      { name: 'Soft Purple', color: '#eae6f4' },
                      { name: 'Soft Green', color: '#e6f4ed' },
                      { name: 'Soft Sand', color: '#f4ede6' },
                      { name: 'White', color: '#ffffff' }
                    ]}
                    value={activeItem.bgColor}
                    onChange={(color) => updateItem(activeItemIndex, 'bgColor', color || '#f4eae1')}
                  />
                </div>

                <div className="mb-4">
                  <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Card Background Image</span>
                  <MediaUploadCheck>
                    <MediaUpload
                      onSelect={(media) => updateItem(activeItemIndex, 'imageUrl', media.url)}
                      allowedTypes={['image']}
                      value={activeItem.imageUrl}
                      render={({ open }) => (
                        <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                          <Button variant="secondary" onClick={open}>
                            Choose Image
                          </Button>
                          {activeItem.imageUrl && (
                            <Button 
                              variant="link" 
                              isDestructive 
                              onClick={() => updateItem(activeItemIndex, 'imageUrl', '')}
                            >
                              Clear
                            </Button>
                          )}
                        </div>
                      )}
                    />
                  </MediaUploadCheck>
                  <TextControl
                    label="Or Image URL"
                    value={activeItem.imageUrl}
                    onChange={(val) => updateItem(activeItemIndex, 'imageUrl', val)}
                  />
                </div>
              </div>
            )}
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          {sectionTitle && (
            <h2 className="text-xl md:text-2xl font-extrabold text-[#111111] mb-6 font-sans">
              {sectionTitle}
            </h2>
          )}
          <div className="grid grid-cols-2 md:grid-cols-5 gap-4 font-sans">
            {items.map((item, idx) => {
              const fallbackImg = defImages[idx] || '';
              return (
                <div 
                  key={idx} 
                  onClick={() => setActiveItemIndex(idx)}
                  className={`relative overflow-hidden bg-white border rounded-[20px] flex flex-col h-auto shadow-sm hover:shadow-md transition-all duration-300 cursor-pointer ${
                    activeItemIndex === idx ? 'border-primary border-2 ring-4 ring-primary/10' : 'border-[#eceef1]'
                  }`}
                >
                  <div className="relative w-full aspect-[16/10] overflow-hidden bg-gray-50">
                    <img 
                      src={item.imageUrl || fallbackImg} 
                      alt={item.title} 
                      className="w-full h-full object-cover pointer-events-none" 
                    />
                  </div>
                  <div 
                    className="p-3.5 flex flex-col items-center justify-center text-center"
                    style={{ backgroundColor: item.bgColor || '#eedec9' }}
                  >
                    <span className="font-extrabold text-[13px] md:text-[14px] text-[#111111] leading-tight line-clamp-1">
                      {item.title || `Item #${idx + 1}`}
                    </span>
                    <span className="text-[10px] md:text-[11px] font-extrabold text-[#8c8c8c] mt-1 line-clamp-1">
                      {item.linkLabel || 'Shop Now'}
                    </span>
                  </div>
                </div>
              );
            })}
          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
