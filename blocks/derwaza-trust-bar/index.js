import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, TextControl, ColorPalette, TextareaControl, SelectControl } from '@wordpress/components';
import { useState } from '@wordpress/element';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <rect width="18" height="18" x="3" y="3" rx="2" />
    <path d="M12 8v8" />
    <path d="M8 12h8" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { items, bgColor, textColor, iconColor } = attributes;
    const [activeItemIndex, setActiveItemIndex] = useState(0);

    const updateItem = (index, key, value) => {
      const nextItems = items.map((item, i) => {
        if (i === index) {
          return { ...item, [key]: value };
        }
        return item;
      });
      setAttributes({ items: nextItems });
    };

    const activeItem = items[activeItemIndex] || items[0] || {};
    const blockProps = useBlockProps({ 
      className: 'derwaza-trust-bar-editor w-full max-w-[1200px] mx-auto py-6 px-4',
    });

    return (
      <>
        <InspectorControls>
          <PanelBody title="Color Customization" initialOpen={true}>
            <div className="mb-5">
              <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Bar Background Color</span>
              <ColorPalette
                colors={[
                  { name: 'White', color: '#ffffff' },
                  { name: 'Light Slate', color: '#f8fafc' },
                  { name: 'Light Gold', color: '#fffbeb' },
                  { name: 'Charcoal', color: '#1a1a15' }
                ]}
                value={bgColor}
                onChange={(color) => setAttributes({ bgColor: color || '#ffffff' })}
              />
            </div>

            <div className="mb-5">
              <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Text Color</span>
              <ColorPalette
                colors={[
                  { name: 'Dark Gray', color: '#1b1c1c' },
                  { name: 'White', color: '#ffffff' },
                  { name: 'Secondary Blue', color: '#194ae4' }
                ]}
                value={textColor}
                onChange={(color) => setAttributes({ textColor: color || '#1b1c1c' })}
              />
            </div>

            <div className="mb-5">
              <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Icon Color</span>
              <ColorPalette
                colors={[
                  { name: 'Gold/Brown', color: '#8B5E3C' },
                  { name: 'Emerald Green', color: '#059669' },
                  { name: 'Sky Blue', color: '#0ea5e9' },
                  { name: 'White', color: '#ffffff' }
                ]}
                value={iconColor}
                onChange={(color) => setAttributes({ iconColor: color || '#8B5E3C' })}
              />
            </div>
          </PanelBody>

          <PanelBody title="Bar Items Settings" initialOpen={true}>
            {/* Selector */}
            <div className="mb-5">
              <SelectControl
                label="Select Feature Item to Edit"
                value={activeItemIndex.toString()}
                options={items.map((item, index) => ({
                  label: `Item #${index + 1}: ${item.title || 'Untitled'}`,
                  value: index.toString()
                }))}
                onChange={(value) => setActiveItemIndex(parseInt(value, 10))}
              />
            </div>

            {/* Editing fields */}
            {activeItem && (
              <div className="active-item-fields">
                <div className="mb-5">
                  <TextControl
                    label="Feature Title"
                    value={activeItem.title}
                    onChange={(value) => updateItem(activeItemIndex, 'title', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextControl
                    label="Feature Subtitle"
                    value={activeItem.subtitle}
                    onChange={(value) => updateItem(activeItemIndex, 'subtitle', value)}
                  />
                </div>

                <div className="mb-5">
                  <TextareaControl
                    label="Icon SVG Code"
                    help="Paste raw SVG tag string. Ensure fill/stroke attribute uses 'currentColor'."
                    value={activeItem.iconSvg}
                    onChange={(value) => updateItem(activeItemIndex, 'iconSvg', value)}
                    rows={8}
                  />
                </div>
              </div>
            )}
          </PanelBody>
        </InspectorControls>

        <div {...blockProps}>
          {/* Main Visual Render in Editor */}
          <div 
            className="rounded-[20px] shadow-[0_10px_35px_rgba(0,0,0,0.05)] border border-black/[0.04] p-5 md:p-6 transition-all duration-300"
            style={{ backgroundColor: bgColor, color: textColor }}
          >
            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-y-6 lg:gap-y-0 lg:divide-x lg:divide-black/10 rtl:lg:divide-x-reverse">
              {items.map((item, index) => (
                <div 
                  key={index}
                  className={`flex items-center gap-4 py-2 px-6 lg:justify-center transition-colors cursor-pointer ${
                    activeItemIndex === index ? 'bg-gray-100/10 border border-dashed border-gray-400/20 rounded-lg' : 'border border-transparent'
                  }`}
                  onClick={() => setActiveItemIndex(index)}
                >
                  {/* SVG Icon */}
                  {item.iconSvg ? (
                    <div 
                      className="flex-shrink-0 w-8 h-8 flex items-center justify-center derwaza-trust-icon"
                      style={{ color: iconColor }}
                      dangerouslySetInnerHTML={{ __html: item.iconSvg }}
                    />
                  ) : (
                    <div className="w-8 h-8 rounded bg-gray-100 flex-shrink-0" />
                  )}

                  {/* Text Container */}
                  <div className="flex flex-col">
                    <span className="font-bold text-sm md:text-base leading-tight font-sans">
                      {item.title || `Item #${index + 1}`}
                    </span>
                    <span className="text-xs font-sans opacity-70 mt-0.5">
                      {item.subtitle || 'Short description'}
                    </span>
                  </div>
                </div>
              ))}
            </div>
          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
