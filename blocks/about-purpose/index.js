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
    <circle cx="12" cy="12" r="10" />
    <path d="m9 12 2 2 4-4" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const {
      eyebrow,
      titleLine1,
      titleLine2,
      badgeLabel,
      badgeText,
      paragraphs,
    } = attributes;
    const blockProps = useBlockProps({
      className: "py-10 md:py-16 bg-surface",
    });

    const updateParagraph = (index, value) => {
      const next = [...paragraphs];
      next[index] = value;
      setAttributes({ paragraphs: next });
    };
    const addParagraph = () =>
      setAttributes({ paragraphs: [...paragraphs, "New paragraph."] });
    const removeParagraph = (index) =>
      setAttributes({ paragraphs: paragraphs.filter((_, i) => i !== index) });

    return (
      <section {...blockProps}>
        <div className="container-custom grid grid-cols-1 md:grid-cols-2 gap-20 items-start">
          <div>
            <RichText
              tagName="span"
              className="text-secondary font-bold tracking-[0.2em] text-xs uppercase mb-4 block"
              value={eyebrow}
              onChange={(value) => setAttributes({ eyebrow: value })}
              allowedFormats={[]}
            />
            <h2 className="text-primary text-h2 mb-4">
              <RichText
                tagName="span"
                value={titleLine1}
                onChange={(value) => setAttributes({ titleLine1: value })}
                allowedFormats={[]}
              />
              <br />
              <RichText
                tagName="span"
                value={titleLine2}
                onChange={(value) => setAttributes({ titleLine2: value })}
                allowedFormats={[]}
              />
            </h2>
            <div className="inline-block px-4 py-2 bg-primary/5 border-l-4 border-secondary mt-4">
              <p className="text-primary font-bold text-sm uppercase tracking-wider">
                <RichText
                  tagName="span"
                  value={badgeLabel}
                  onChange={(value) => setAttributes({ badgeLabel: value })}
                  allowedFormats={[]}
                />{" "}
                <RichText
                  tagName="span"
                  className="text-on-surface-variant font-medium normal-case"
                  value={badgeText}
                  onChange={(value) => setAttributes({ badgeText: value })}
                  allowedFormats={[]}
                />
              </p>
            </div>
          </div>
          <div className="space-y-6 text-on-surface-variant text-body-lg leading-relaxed">
            {paragraphs.map((paragraph, index) => (
              <div key={index} className="relative group">
                <RichText
                  tagName="p"
                  value={paragraph}
                  onChange={(value) => updateParagraph(index, value)}
                  allowedFormats={["core/bold", "core/italic"]}
                />
                <Button
                  className="absolute -top-2 -right-2 opacity-0 group-hover:opacity-100"
                  isDestructive
                  isSmall
                  onClick={() => removeParagraph(index)}
                >
                  ×
                </Button>
              </div>
            ))}
            <Button variant="secondary" onClick={addParagraph}>
              + Add paragraph
            </Button>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
