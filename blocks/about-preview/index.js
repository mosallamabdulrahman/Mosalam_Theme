import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <circle cx="12" cy="8" r="4" />
    <path d="M4 21v-1a8 8 0 0 1 16 0v1" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, paragraph1, paragraph2, image, stats } = attributes;
    const blockProps = useBlockProps({ className: 'min-h-screen w-full relative cinematic-section bg-white py-24' });

    const updateStat = (index, key, value) => {
      const next = stats.map((s, i) => (i === index ? { ...s, [key]: value } : s));
      setAttributes({ stats: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom w-full">
          <div className="flex flex-col lg:flex-row gap-16 items-center">
            <div className="w-full lg:w-1/2">
              <RichText tagName="span" className="text-overline-lg text-secondary mb-6 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
              <RichText tagName="h2" className="text-h2 text-[#001b35] mb-8" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
              <RichText tagName="p" className="text-body-lg text-on-surface-variant mb-6" value={paragraph1} onChange={(value) => setAttributes({ paragraph1: value })} allowedFormats={['core/bold', 'core/italic']} />
              <RichText tagName="p" className="text-body-lg text-on-surface-variant mb-12" value={paragraph2} onChange={(value) => setAttributes({ paragraph2: value })} allowedFormats={['core/bold', 'core/italic']} />
              <div className="grid grid-cols-2 gap-8">
                {stats.map((stat, index) => (
                  <div key={index} className="border-l-4 border-secondary pl-6">
                    <RichText tagName="h4" className="text-h1 text-[#001b35] mb-2" value={stat.value} onChange={(value) => updateStat(index, 'value', value)} allowedFormats={[]} />
                    <RichText tagName="p" className="text-body-sm text-on-surface-variant" value={stat.label} onChange={(value) => updateStat(index, 'label', value)} allowedFormats={[]} />
                  </div>
                ))}
              </div>
            </div>
            <div className="w-full lg:w-1/2 h-[600px] relative">
              <InspectorControls>
                <PanelBody title="Image">
                  <MediaUploadCheck>
                    <MediaUpload
                      onSelect={(media) => setAttributes({ image: media.url })}
                      allowedTypes={['image']}
                      render={({ open }) => <Button variant="secondary" onClick={open}>Choose image</Button>}
                    />
                  </MediaUploadCheck>
                </PanelBody>
              </InspectorControls>
              <img className="w-full h-full object-cover rounded-lg shadow-2xl" alt="Team collaboration" src={image} referrerPolicy="no-referrer" />
              <div className="absolute inset-0 bg-[#001b35]/10 rounded-lg"></div>
            </div>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
