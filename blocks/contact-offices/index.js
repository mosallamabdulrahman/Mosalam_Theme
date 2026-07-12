import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import metadata from "./block.json";

const icon = (
  <svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    strokeWidth="2"
    strokeLinecap="round"
    strokeLinejoin="round"
  >
    <path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" />
    <circle cx="12" cy="10" r="3" />
  </svg>
);

const MapPinLarge = () => (
  <svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    strokeWidth="2"
    strokeLinecap="round"
    strokeLinejoin="round"
    className="w-32 h-32"
    aria-hidden="true"
  >
    <path d="M20 10c0 4.9-8 12-8 12S4 14.9 4 10a8 8 0 1 1 16 0Z" />
    <circle cx="12" cy="10" r="3" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, offices } = attributes;
    const blockProps = useBlockProps({
      className:
        "py-10 md:py-16 bg-surface-container-low border-t border-black/5",
    });

    const updateOffice = (index, key, value) => {
      const next = offices.map((o, i) =>
        i === index ? { ...o, [key]: value } : o,
      );
      setAttributes({ offices: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom">
          <div className="mb-16">
            <RichText
              tagName="span"
              className="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"
              value={eyebrow}
              onChange={(value) => setAttributes({ eyebrow: value })}
              allowedFormats={[]}
            />
            <RichText
              tagName="h2"
              className="text-h2 text-primary"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
              allowedFormats={[]}
            />
          </div>

          <div className="grid grid-cols-1 md:grid-cols-2 gap-8">
            {offices.map((office, index) => (
              <div
                key={index}
                className="bg-white p-10 shadow-sm relative overflow-hidden group"
              >
                <div className="absolute top-0 right-0 p-6 opacity-5">
                  <MapPinLarge />
                </div>
                <RichText
                  tagName="h4"
                  className="text-tertiary text-[10px] font-bold uppercase tracking-[0.2em] mb-4"
                  value={office.label}
                  onChange={(value) => updateOffice(index, "label", value)}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="h3"
                  className="text-h3 text-primary mb-6"
                  value={office.city}
                  onChange={(value) => updateOffice(index, "city", value)}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="p"
                  className="text-on-surface-variant text-body leading-relaxed mb-8 whitespace-pre-line"
                  value={office.address}
                  onChange={(value) => updateOffice(index, "address", value)}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="p"
                  className="text-primary font-bold tracking-wider"
                  value={office.phone}
                  onChange={(value) => updateOffice(index, "phone", value)}
                  allowedFormats={[]}
                />
              </div>
            ))}
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
