import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M12 2 2 7l10 5 10-5-10-5Z" />
    <path d="m2 17 10 5 10-5" />
    <path d="m2 12 10 5 10-5" />
  </svg>
);

const ShieldCheck = () => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-10 h-10 text-secondary" aria-hidden="true">
    <path d="M20 13c0 5-3.5 7.5-7.7 8.9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 .6-.9l7-3a1 1 0 0 1 .8 0l7 3a1 1 0 0 1 .6.9Z" />
    <path d="m9 12 2 2 4-4" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { title, description, items, highlightLabel, highlightTitle, highlightDescription } = attributes;
    const blockProps = useBlockProps({ className: 'py-32 bg-surface relative overflow-hidden' });

    const updateItem = (index, key, value) => {
      const next = items.map((it, i) => (i === index ? { ...it, [key]: value } : it));
      setAttributes({ items: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom grid grid-cols-1 lg:grid-cols-12 gap-16 relative z-10">
          <div className="lg:col-span-5 relative">
            <div>
              <RichText tagName="h2" className="text-h2 text-primary mb-8" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
              <div className="w-16 h-1 bg-secondary mb-8"></div>
              <RichText tagName="p" className="text-on-surface-variant text-body-lg" value={description} onChange={(value) => setAttributes({ description: value })} allowedFormats={['core/bold', 'core/italic']} />
            </div>
          </div>
          <div className="lg:col-span-7 space-y-12">
            {items.map((item, index) => (
              <div key={index} className="group border-b border-black/5 pb-10">
                <h3 className="text-h3 text-primary mb-4 flex items-center gap-4">
                  <span className="text-secondary font-mono tracking-tighter">{item.number}</span>
                  <RichText tagName="span" value={item.title} onChange={(value) => updateItem(index, 'title', value)} allowedFormats={[]} />
                </h3>
                <RichText tagName="p" className="text-on-surface-variant text-body leading-relaxed pl-12" value={item.description} onChange={(value) => updateItem(index, 'description', value)} allowedFormats={['core/bold', 'core/italic']} />
              </div>
            ))}

            <div className="p-10 bg-primary text-white relative overflow-hidden shadow-2xl mt-16 group">
              <div className="relative z-10">
                <div className="flex justify-between items-start mb-6">
                  <ShieldCheck />
                  <RichText tagName="span" className="text-[10px] font-bold uppercase tracking-[0.3em] text-white/50" value={highlightLabel} onChange={(value) => setAttributes({ highlightLabel: value })} allowedFormats={[]} />
                </div>
                <RichText tagName="h4" className="text-h3 mb-4" value={highlightTitle} onChange={(value) => setAttributes({ highlightTitle: value })} allowedFormats={[]} />
                <RichText tagName="p" className="text-white/80 font-light text-body-lg leading-relaxed" value={highlightDescription} onChange={(value) => setAttributes({ highlightDescription: value })} allowedFormats={['core/bold', 'core/italic']} />
              </div>
            </div>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
