import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <circle cx="12" cy="12" r="10" />
    <path d="M2 12h20" />
    <path d="M12 2a15.3 15.3 0 0 1 0 20" />
    <path d="M12 2a15.3 15.3 0 0 0 0 20" />
  </svg>
);

const MapPin = () => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-6 h-6" aria-hidden="true">
    <path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" />
    <circle cx="12" cy="10" r="3" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, offices, mapImage, overlayLabel, overlayAddress, overlayPhoneLabel, overlayPhone, badgeText } = attributes;
    const blockProps = useBlockProps({ className: 'py-32 bg-primary overflow-hidden relative' });

    const updateOffice = (index, key, value) => {
      const next = offices.map((o, i) => (i === index ? { ...o, [key]: value } : o));
      setAttributes({ offices: next });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title="Map image">
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) => setAttributes({ mapImage: media.url })}
                allowedTypes={['image']}
                render={({ open }) => <Button variant="secondary" onClick={open}>Choose map image</Button>}
              />
            </MediaUploadCheck>
          </PanelBody>
        </InspectorControls>
        <section {...blockProps} id="location">
          <div className="container-custom grid grid-cols-1 lg:grid-cols-2 gap-20 items-center">
            <div className="space-y-12">
              <div>
                <RichText tagName="span" className="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block" value={eyebrow} onChange={(value) => setAttributes({ eyebrow: value })} allowedFormats={[]} />
                <RichText tagName="h2" className="text-white text-h1 leading-tight" value={title} onChange={(value) => setAttributes({ title: value })} allowedFormats={[]} />
              </div>
              <div className="bg-white/5 backdrop-blur-xl border border-white/10 p-10 space-y-8">
                {offices.map((office, index) => (
                  <div key={index} className={index > 0 ? 'py-8 border-t border-white/10' : ''}>
                    <RichText tagName="h4" className="text-tertiary text-[10px] font-bold uppercase tracking-[0.2em] mb-4" value={office.label} onChange={(value) => updateOffice(index, 'label', value)} allowedFormats={[]} />
                    <RichText tagName="p" className="text-white text-2xl font-light leading-relaxed whitespace-pre-line" value={office.text} onChange={(value) => updateOffice(index, 'text', value)} allowedFormats={[]} />
                  </div>
                ))}
              </div>
            </div>
            <div className="relative">
              <div className="aspect-square bg-primary_container border border-white/10 relative group overflow-hidden shadow-2xl">
                <img className="w-full h-full object-cover opacity-60 mix-blend-luminosity" alt="Dark stylized technical map" src={mapImage} referrerPolicy="no-referrer" />
                <div className="absolute inset-0 flex items-center justify-center p-8">
                  <div className="w-full max-w-sm bg-surface p-8 shadow-2xl relative">
                    <div className="mb-6">
                      <RichText tagName="h5" className="text-secondary text-[10px] font-bold uppercase tracking-widest mb-2" value={overlayLabel} onChange={(value) => setAttributes({ overlayLabel: value })} allowedFormats={[]} />
                      <RichText tagName="p" className="text-primary text-sm font-medium leading-relaxed whitespace-pre-line" value={overlayAddress} onChange={(value) => setAttributes({ overlayAddress: value })} allowedFormats={[]} />
                    </div>
                    <div>
                      <RichText tagName="h5" className="text-secondary text-[10px] font-bold uppercase tracking-widest mb-2" value={overlayPhoneLabel} onChange={(value) => setAttributes({ overlayPhoneLabel: value })} allowedFormats={[]} />
                      <RichText tagName="p" className="text-primary text-lg font-bold" value={overlayPhone} onChange={(value) => setAttributes({ overlayPhone: value })} allowedFormats={[]} />
                    </div>
                    <div className="absolute -top-4 -right-4 bg-tertiary text-white p-4 shadow-lg">
                      <MapPin />
                    </div>
                  </div>
                </div>
                <div className="absolute top-6 left-6 bg-secondary px-4 py-2 text-white text-[10px] font-bold uppercase tracking-[0.2em] shadow-lg">
                  <RichText tagName="span" value={badgeText} onChange={(value) => setAttributes({ badgeText: value })} allowedFormats={[]} />
                </div>
              </div>
            </div>
          </div>
        </section>
      </>
    );
  },
  save: () => null,
});
