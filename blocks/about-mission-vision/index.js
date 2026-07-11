import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { ToggleControl } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7Z" />
    <circle cx="12" cy="12" r="3" />
  </svg>
);

const offsetClass = (index) => {
  if (index === 1) return 'lg:-mt-12 z-10';
  if (index === 2) return 'lg:mt-12';
  return '';
};

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { cards } = attributes;
    const blockProps = useBlockProps({ className: 'py-32 bg-surface-container-low' });

    const updateCard = (index, key, value) => {
      const next = cards.map((c, i) => (i === index ? { ...c, [key]: value } : c));
      setAttributes({ cards: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom p-0 md:px-8">
          <div className="grid grid-cols-1 lg:grid-cols-3 gap-8">
            {cards.map((card, index) => (
              <div
                key={index}
                className={`p-12 aspect-[4/5] flex flex-col justify-between shadow-sm relative overflow-hidden group ${offsetClass(index)} ${
                  card.dark ? 'bg-primary text-white shadow-2xl' : 'bg-white'
                }`}
              >
                <span className={`font-black text-8xl absolute top-8 right-8 ${card.dark ? 'text-white/5' : 'text-primary/5'}`}>{card.number}</span>
                <div className="relative z-10 mt-auto">
                  <RichText tagName="h3" className={`text-h3 mb-6 ${card.dark ? '' : 'text-primary'}`} value={card.title} onChange={(value) => updateCard(index, 'title', value)} allowedFormats={[]} />
                  <RichText
                    tagName="p"
                    className={`leading-relaxed text-body ${card.dark ? 'text-slate-300' : 'text-on-surface-variant'}`}
                    value={card.description}
                    onChange={(value) => updateCard(index, 'description', value)}
                    allowedFormats={['core/bold', 'core/italic']}
                  />
                  <ToggleControl label="Dark card" checked={!!card.dark} onChange={(value) => updateCard(index, 'dark', value)} __nextHasNoMarginBottom />
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
