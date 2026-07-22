import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
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
    <path d="M3 21h18" />
    <path d="M5 21V7l7-4 7 4v14" />
    <path d="M9 9h1M9 13h1M14 9h1M14 13h1M10 21v-4h4v4" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, description, sectors } = attributes;
    const blockProps = useBlockProps({
      className: "min-h-screen w-full relative cinematic-section bg-[#fcf9f8]",
    });

    const updateSector = (index, key, value) => {
      const next = sectors.map((s, i) =>
        i === index ? { ...s, [key]: value } : s,
      );
      setAttributes({ sectors: next });
    };

    return (
      <section {...blockProps}>
        <div className="cinematic-bg flex flex-col">
          <div className="h-1/2 flex flex-col md:flex-row">
            {sectors.map((sector, index) => (
              <div
                key={index}
                className="w-full md:w-1/4 h-64 md:h-full relative overflow-hidden group"
              >
                <img
                  className="w-full h-full object-cover grayscale group-hover:grayscale-0 group-hover:scale-110 transition-all duration-1000"
                  src={sector.image}
                  alt={sector.title}
                />
                <div className="absolute inset-0 bg-primary/60 flex items-end p-12">
                  <div>
                    <RichText
                      tagName="h4"
                      className="text-white text-h3 mb-4"
                      value={sector.title}
                      onChange={(value) => updateSector(index, "title", value)}
                      allowedFormats={[]}
                    />
                    <RichText
                      tagName="p"
                      className="text-white/60 text-body-sm"
                      value={sector.description}
                      onChange={(value) =>
                        updateSector(index, "description", value)
                      }
                      allowedFormats={[]}
                    />
                  </div>
                </div>
              </div>
            ))}
          </div>
          <div className="h-1/2 flex items-center justify-center pad-element bg-white">
            <div className="container-custom flex justify-center w-full">
              <div className="max-w-4xl text-center">
                <RichText
                  tagName="span"
                  className="text-overline-lg text-secondary mb-8 block"
                  value={eyebrow}
                  onChange={(value) => setAttributes({ eyebrow: value })}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="h2"
                  className="text-h2 text-primary mb-8"
                  value={title}
                  onChange={(value) => setAttributes({ title: value })}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="p"
                  className="text-body-lg text-on-surface-variant"
                  value={description}
                  onChange={(value) => setAttributes({ description: value })}
                  allowedFormats={["core/bold", "core/italic"]}
                />
              </div>
            </div>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
