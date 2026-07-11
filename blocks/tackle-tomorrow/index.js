import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <circle cx="12" cy="12" r="9" />
    <circle cx="12" cy="12" r="5" />
    <circle cx="12" cy="12" r="1" />
  </svg>
);

const ArrowRight = () => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-4 h-4 group-hover:translate-x-2 transition-transform" aria-hidden="true">
    <path d="M5 12h14" />
    <path d="m12 5 7 7-7 7" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { title, cards } = attributes;
    const blockProps = useBlockProps({ className: 'w-full relative bg-secondary text-white text-center py-16 md:py-20 lg:py-24' });

    const updateCard = (index, key, value) => {
      const next = cards.map((c, i) => (i === index ? { ...c, [key]: value } : c));
      setAttributes({ cards: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom">
          <div className="mx-auto">
            <RichText tagName="h2" className="text-h1 mb-10 md:mb-12" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
            <div className="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6 md:gap-8 text-left">
              {cards.map((card, index) => (
                <div key={index} className={`p-6 md:p-8 lg:p-10 border border-white/20 hover:bg-white/5 transition-all ${index === 2 ? 'md:col-span-2 xl:col-span-1' : ''}`}>
                  <RichText tagName="h3" className="text-h3 mb-4" value={card.title} onChange={(value) => updateCard(index, 'title', value)} allowedFormats={[]} />
                  <RichText tagName="p" className="text-white/70 text-body-sm mb-8" value={card.description} onChange={(value) => updateCard(index, 'description', value)} allowedFormats={['core/bold', 'core/italic']} />
                  <span className="flex items-center gap-4 text-overline group">
                    <RichText tagName="span" value={card.ctaLabel} onChange={(value) => updateCard(index, 'ctaLabel', value)} allowedFormats={[]} />
                    <ArrowRight />
                  </span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
