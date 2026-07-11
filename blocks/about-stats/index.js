import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { ToggleControl, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M3 3v18h18" />
    <path d="M18 17V9M13 17V5M8 17v-3" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { items } = attributes;
    const blockProps = useBlockProps({ className: 'py-24 bg-surface-container-low' });

    const updateItem = (index, key, value) => {
      const next = items.map((item, i) => (i === index ? { ...item, [key]: value } : item));
      setAttributes({ items: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom">
          <div className="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-6 gap-[2px] bg-outline-variant/20 shadow-sm overflow-hidden">
            {items.map((item, index) => (
              <div key={index} className="bg-white p-10 flex flex-col justify-between aspect-square hover:bg-surface-container-low transition-colors duration-500">
                <RichText tagName="span" className="text-on-surface-variant text-sm font-medium" value={item.label} onChange={(value) => updateItem(index, 'label', value)} allowedFormats={[]} />
                <div className="space-y-2">
                  <RichText tagName="span" className={`block text-4xl font-black ${item.highlight ? 'text-secondary' : 'text-primary'}`} value={item.value} onChange={(value) => updateItem(index, 'value', value)} allowedFormats={[]} />
                  <RichText tagName="span" className="block text-on-surface-variant text-[10px] uppercase tracking-widest gap-2" value={item.sublabel} onChange={(value) => updateItem(index, 'sublabel', value)} allowedFormats={[]} />
                  <ToggleControl label="Highlight (secondary color)" checked={!!item.highlight} onChange={(value) => updateItem(index, 'highlight', value)} __nextHasNoMarginBottom />
                </div>
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
