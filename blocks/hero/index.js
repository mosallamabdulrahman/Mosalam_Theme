import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="M4 4h16v12H4z" />
    <path d="m4 16 4-4 3 3 5-5 4 4" />
    <path d="M4 20h16" />
  </svg>
);

const ArrowRight = () => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5 group-hover:translate-x-2 transition-transform" aria-hidden="true">
    <path d="M5 12h14" />
    <path d="m12 5 7 7-7 7" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, description, ctaLabel, backgroundImage, scrollLabel } = attributes;
    const blockProps = useBlockProps({ className: 'w-full h-[600px] relative flex flex-col' });

    return (
      <>
        <InspectorControls>
          <PanelBody title="Background">
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) => setAttributes({ backgroundImage: media.url })}
                allowedTypes={['image']}
                render={({ open }) => (
                  <Button variant="secondary" onClick={open}>
                    Choose background image
                  </Button>
                )}
              />
            </MediaUploadCheck>
            <TextControl label="Background image URL" value={backgroundImage} onChange={(value) => setAttributes({ backgroundImage: value })} __next40pxDefaultSize __nextHasNoMarginBottom />
            <TextControl label="Scroll indicator label" value={scrollLabel} onChange={(value) => setAttributes({ scrollLabel: value })} __next40pxDefaultSize __nextHasNoMarginBottom />
          </PanelBody>
        </InspectorControls>
        <section {...blockProps}>
          <div className="flex-grow relative flex items-center w-full overflow-hidden">
            <div className="cinematic-bg absolute inset-0">
              <img 
                className="w-full h-full object-cover" 
                alt="abstract high-tech digital background" 
                src={backgroundImage || (window.mosalamThemeUrl ? window.mosalamThemeUrl + '/assets/images/abstract-high-tech-digital-background.webp' : '')} 
                referrerPolicy="no-referrer" 
              />
              <div className="absolute inset-0 bg-black/40"></div>
            </div>
            <div className="cinematic-content container-custom py-6 md:py-12">
              <div className="max-w-4xl">
                <RichText tagName="span" className="text-overline-lg text-secondary-fixed mb-8 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
                <RichText tagName="h1" className="text-h1 text-white mb-8" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
                <RichText tagName="p" className="text-body-lg text-white/80 mb-12 max-w-2xl" value={description} onChange={(value) => setAttributes({ description: value })} allowedFormats={['core/bold', 'core/italic']} />
                <div className="flex gap-6">
                  <span className="bg-secondary text-white px-10 py-5 rounded-action text-overline-lg hover:bg-white hover:text-secondary transition-all inline-flex items-center gap-4 group">
                    <RichText tagName="span" value={ctaLabel} onChange={(value) => setAttributes({ ctaLabel: value })} allowedFormats={[]} />
                    <ArrowRight />
                  </span>
                </div>
              </div>
            </div>
            <div className="absolute bottom-8 left-1/2 -translate-x-1/2 flex flex-col items-center gap-4 text-white/60 z-20">
              <span className="text-[10px] uppercase tracking-[0.3em]">{scrollLabel}</span>
              <span className="w-[2px] h-12 bg-white/20 relative overflow-hidden">
                <span className="absolute inset-x-0 top-0 h-10 bg-secondary-fixed"></span>
              </span>
            </div>
          </div>
        </section>
      </>
    );
  },
  save: () => null,
});
