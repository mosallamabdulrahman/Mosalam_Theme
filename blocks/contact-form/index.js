import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText } from '@wordpress/block-editor';
import { Button, TextControl } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <path d="m22 2-7 20-4-9-9-4Z" />
    <path d="M22 2 11 13" />
  </svg>
);

const ICONS = {
  mail: <><rect width="20" height="16" x="2" y="4" rx="2" /><path d="m22 7-10 6L2 7" /></>,
  phone: <path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.5c.9.3 1.8.6 2.8.7A2 2 0 0 1 22 16.9Z" />,
  globe: <><circle cx="12" cy="12" r="10" /><path d="M2 12h20" /><path d="M12 2a15.3 15.3 0 0 1 0 20" /><path d="M12 2a15.3 15.3 0 0 0 0 20" /></>,
};

const ContactIcon = ({ name }) => (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round" className="w-5 h-5" aria-hidden="true">
    {ICONS[name] || ICONS.mail}
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const {
      titleLine1, titleLine2, description, contactItems,
      formTitle, nameLabel, namePlaceholder, emailLabel, emailPlaceholder,
      orgLabel, orgPlaceholder, inquiryLabel, inquiryOptions,
      messageLabel, messagePlaceholder, submitLabel,
    } = attributes;
    const blockProps = useBlockProps({ className: 'py-24 bg-surface' });

    const updateItem = (index, key, value) => {
      const next = contactItems.map((item, i) => (i === index ? { ...item, [key]: value } : item));
      setAttributes({ contactItems: next });
    };
    const updateLine = (itemIndex, lineIndex, value) => {
      const next = contactItems.map((item, i) => {
        if (i !== itemIndex) return item;
        const lines = item.lines.map((line, j) => (j === lineIndex ? { ...line, text: value } : line));
        return { ...item, lines };
      });
      setAttributes({ contactItems: next });
    };
    const updateOption = (index, value) => {
      const next = [...inquiryOptions];
      next[index] = value;
      setAttributes({ inquiryOptions: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom grid grid-cols-1 lg:grid-cols-12 gap-16 lg:gap-24">
          <div className="lg:col-span-5 space-y-16">
            <div>
              <h2 className="text-h2 text-primary mb-6">
                <RichText tagName="span" value={titleLine1} onChange={(value) => setAttributes({ titleLine1: value })} allowedFormats={[]} />
                <br />
                <RichText tagName="span" value={titleLine2} onChange={(value) => setAttributes({ titleLine2: value })} allowedFormats={[]} />
              </h2>
              <RichText tagName="p" className="text-on-surface-variant text-body-lg leading-relaxed" value={description} onChange={(value) => setAttributes({ description: value })} allowedFormats={['core/bold', 'core/italic']} />
            </div>

            <div className="space-y-10">
              {contactItems.map((item, index) => (
                <div key={index} className="flex gap-6 items-start">
                  <div className="w-12 h-12 bg-surface-container-low flex items-center justify-center shrink-0 border border-black/5">
                    <ContactIcon name={item.icon} />
                  </div>
                  <div className="flex-1">
                    <RichText tagName="h4" className="text-h4 text-primary mb-2" value={item.title} onChange={(value) => updateItem(index, 'title', value)} allowedFormats={[]} />
                    {item.lines.map((line, lineIndex) => (
                      <RichText
                        key={lineIndex}
                        tagName="p"
                        className={line.href ? 'text-body text-secondary block' : 'text-body text-on-surface-variant'}
                        value={line.text}
                        onChange={(value) => updateLine(index, lineIndex, value)}
                        allowedFormats={[]}
                      />
                    ))}
                    {item.note && (
                      <RichText tagName="p" className="text-sm text-on-surface-variant/70 mt-1" value={item.note} onChange={(value) => updateItem(index, 'note', value)} allowedFormats={[]} />
                    )}
                  </div>
                </div>
              ))}
            </div>
          </div>

          <div className="lg:col-span-7 border border-black/5">
            <div className="bg-white p-10 md:p-16 shadow-xl relative overflow-hidden">
              <div className="absolute top-0 left-0 w-full h-1 bg-secondary"></div>
              <RichText tagName="h3" className="text-h3 text-primary mb-8" value={formTitle} onChange={(value) => setAttributes({ formTitle: value })} allowedFormats={[]} />

              <div className="space-y-8">
                <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
                  <div className="flex flex-col gap-2">
                    <RichText tagName="label" className="text-sm font-bold text-primary uppercase tracking-wider" value={nameLabel} onChange={(value) => setAttributes({ nameLabel: value })} allowedFormats={[]} />
                    <TextControl value={namePlaceholder} onChange={(value) => setAttributes({ namePlaceholder: value })} help="Placeholder text" __next40pxDefaultSize __nextHasNoMarginBottom />
                  </div>
                  <div className="flex flex-col gap-2">
                    <RichText tagName="label" className="text-sm font-bold text-primary uppercase tracking-wider" value={emailLabel} onChange={(value) => setAttributes({ emailLabel: value })} allowedFormats={[]} />
                    <TextControl value={emailPlaceholder} onChange={(value) => setAttributes({ emailPlaceholder: value })} help="Placeholder text" __next40pxDefaultSize __nextHasNoMarginBottom />
                  </div>
                </div>

                <div className="flex flex-col gap-2">
                  <RichText tagName="label" className="text-sm font-bold text-primary uppercase tracking-wider" value={orgLabel} onChange={(value) => setAttributes({ orgLabel: value })} allowedFormats={[]} />
                  <TextControl value={orgPlaceholder} onChange={(value) => setAttributes({ orgPlaceholder: value })} help="Placeholder text" __next40pxDefaultSize __nextHasNoMarginBottom />
                </div>

                <div className="flex flex-col gap-2">
                  <RichText tagName="label" className="text-sm font-bold text-primary uppercase tracking-wider" value={inquiryLabel} onChange={(value) => setAttributes({ inquiryLabel: value })} allowedFormats={[]} />
                  <div className="w-full bg-surface-container-low border-b-2 border-transparent px-4 py-4 text-primary">
                    {inquiryOptions.map((option, index) => (
                      <TextControl key={index} value={option} onChange={(value) => updateOption(index, value)} __next40pxDefaultSize __nextHasNoMarginBottom />
                    ))}
                  </div>
                </div>

                <div className="flex flex-col gap-2">
                  <RichText tagName="label" className="text-sm font-bold text-primary uppercase tracking-wider" value={messageLabel} onChange={(value) => setAttributes({ messageLabel: value })} allowedFormats={[]} />
                  <TextControl value={messagePlaceholder} onChange={(value) => setAttributes({ messagePlaceholder: value })} help="Placeholder text" __next40pxDefaultSize __nextHasNoMarginBottom />
                </div>

                <div className="w-full bg-primary text-white py-5 font-bold uppercase tracking-[0.2em] text-sm flex items-center justify-center gap-4 mt-4">
                  <RichText tagName="span" value={submitLabel} onChange={(value) => setAttributes({ submitLabel: value })} allowedFormats={[]} />
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
