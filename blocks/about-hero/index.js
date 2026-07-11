import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M4 4h16v16H4z" />
    <path d="M4 9h16" />
    <path d="M9 4v16" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, titleLine1, titleLine2, description, backgroundImage } = attributes;
    const blockProps = useBlockProps({ className: 'relative h-[450px] flex items-center overflow-hidden bg-primary' });

    return (
      <>
        <InspectorControls>
          <PanelBody title="Background">
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) => setAttributes({ backgroundImage: media.url })}
                allowedTypes={['image']}
                render={({ open }) => <Button variant="secondary" onClick={open}>Choose background image</Button>}
              />
            </MediaUploadCheck>
          </PanelBody>
        </InspectorControls>
        <section {...blockProps}>
          <div className="absolute inset-0 z-0">
            <img className="w-full h-full object-cover opacity-40 mix-blend-overlay" alt="Sophisticated server room with deep blue ambient lighting" src={backgroundImage} referrerPolicy="no-referrer" />
            <div className="absolute inset-0 bg-gradient-to-r from-primary via-primary/80 to-transparent"></div>
          </div>
          <div className="relative z-10 container-custom py-24">
            <div className="max-w-3xl py-24">
              <RichText tagName="span" className="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-6 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
              <h1 className="text-white text-h1 mb-4 flex flex-col">
                <RichText tagName="span" value={titleLine1} onChange={(value) => setAttributes({ titleLine1: value })} allowedFormats={[]} />
                <RichText tagName="span" className="text-secondary text-sm font-bold tracking-[0.3em] uppercase mt-2" value={titleLine2} onChange={(value) => setAttributes({ titleLine2: value })} allowedFormats={[]} />
              </h1>
              <RichText tagName="p" className="text-white/80 text-body-lg font-light leading-relaxed" value={description} onChange={(value) => setAttributes({ description: value })} allowedFormats={['core/bold', 'core/italic']} />
            </div>
          </div>
        </section>
      </>
    );
  },
  save: () => null,
});
