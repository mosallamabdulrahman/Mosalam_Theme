import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <rect width="20" height="16" x="2" y="4" rx="2" />
    <path d="m22 7-10 6L2 7" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, description, backgroundImage } = attributes;
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
            <img className="w-full h-full object-cover opacity-30 mix-blend-overlay" alt="High-end architectural office interior" src={backgroundImage} referrerPolicy="no-referrer" />
            <div className="absolute inset-0 bg-gradient-to-r from-primary via-primary/90 to-primary/40"></div>
          </div>
          <div className="relative z-10 container-custom py-24">
            <div className="max-w-3xl py-24">
              <RichText tagName="span" className="text-tertiary font-bold tracking-[0.2em] text-xs uppercase mb-6 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
              <RichText tagName="h1" className="text-white text-h1 mb-8" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
              <RichText tagName="p" className="text-white/80 text-body-lg font-light leading-relaxed" value={description} onChange={(value) => setAttributes({ description: value })} allowedFormats={['core/bold', 'core/italic']} />
            </div>
          </div>
        </section>
      </>
    );
  },
  save: () => null,
});
