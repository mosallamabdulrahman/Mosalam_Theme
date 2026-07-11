import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { SelectControl } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M19.5 12.6 12 20l-7.5-7.4A5 5 0 0 1 12 5a5 5 0 0 1 7.5 7.6Z" />
  </svg>
);

const ICONS = {
  shield: <><path d="M20 13c0 5-3.5 7.5-7.7 8.9a1 1 0 0 1-.6 0C7.5 20.5 4 18 4 13V6a1 1 0 0 1 .6-.9l7-3a1 1 0 0 1 .8 0l7 3a1 1 0 0 1 .6.9Z" /><path d="m9 12 2 2 4-4" /></>,
  heart: <path d="M19.5 12.6 12 20l-7.5-7.4A5 5 0 0 1 12 5a5 5 0 0 1 7.5 7.6Z" />,
  users: <><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M22 21v-2a4 4 0 0 0-3-3.9" /><path d="M16 3.1a4 4 0 0 1 0 7.8" /></>,
  zap: <path d="M13 2 3 14h9l-1 8 10-12h-9Z" />,
  home: <><path d="m3 11 9-9 9 9" /><path d="M5 10v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V10" /><path d="M9 21v-6h6v6" /></>,
};

const ValueIcon = ({ name, className }) => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className={className} aria-hidden="true">
    {ICONS[name] || ICONS.shield}
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, values } = attributes;
    const blockProps = useBlockProps({ className: 'py-32 bg-surface' });

    const updateValue = (index, key, value) => {
      const next = values.map((v, i) => (i === index ? { ...v, [key]: value } : v));
      setAttributes({ values: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom text-center mb-20">
          <RichText tagName="span" className="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
          <RichText tagName="h2" className="text-h2 text-primary" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
        </div>
        <div className="container-custom grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-y-16 gap-x-8">
          {values.map((value, index) => (
            <div key={index} className="text-center group">
              <div className="w-20 h-20 bg-surface-container-low flex items-center justify-center mx-auto mb-8 group-hover:bg-secondary group-hover:text-white transition-all duration-500">
                <ValueIcon name={value.icon} className="w-8 h-8" />
              </div>
              <SelectControl
                value={value.icon}
                options={Object.keys(ICONS).map((key) => ({ label: key, value: key }))}
                onChange={(next) => updateValue(index, 'icon', next)}
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <RichText tagName="h4" className="font-bold text-primary mb-4 text-h4" value={value.title} onChange={(v) => updateValue(index, 'title', v)} allowedFormats={[]} />
              <RichText tagName="p" className="text-sm text-on-surface-variant leading-relaxed max-w-[200px] mx-auto" value={value.description} onChange={(v) => updateValue(index, 'description', v)} allowedFormats={['core/bold', 'core/italic']} />
            </div>
          ))}
        </div>
      </section>
    );
  },
  save: () => null,
});
