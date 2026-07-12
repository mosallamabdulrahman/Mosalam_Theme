import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Button, TextControl } from "@wordpress/components";
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
    <rect x="3" y="3" width="7" height="7" />
    <rect x="14" y="3" width="7" height="7" />
    <rect x="3" y="14" width="7" height="7" />
    <rect x="14" y="14" width="7" height="7" />
  </svg>
);

const ArrowRight = () => (
  <svg
    viewBox="0 0 24 24"
    fill="none"
    stroke="currentColor"
    strokeWidth="2"
    strokeLinecap="round"
    strokeLinejoin="round"
    className="w-4 h-4 text-secondary"
    aria-hidden="true"
  >
    <path d="M5 12h14" />
    <path d="m12 5 7 7-7 7" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, categories } = attributes;
    const blockProps = useBlockProps({
      className:
        "min-h-screen w-full relative cinematic-section bg-[#001b35] py-10 md:py-16",
    });

    const updateCategory = (index, key, value) => {
      const next = categories.map((cat, i) =>
        i === index ? { ...cat, [key]: value } : cat,
      );
      setAttributes({ categories: next });
    };
    const addCategory = () =>
      setAttributes({
        categories: [
          ...categories,
          {
            title: "New Category",
            description: "Category description.",
            links: [],
          },
        ],
      });
    const removeCategory = (index) =>
      setAttributes({ categories: categories.filter((_, i) => i !== index) });

    const updateLink = (catIndex, linkIndex, key, value) => {
      const next = categories.map((cat, i) => {
        if (i !== catIndex) return cat;
        const links = cat.links.map((link, j) =>
          j === linkIndex ? { ...link, [key]: value } : link,
        );
        return { ...cat, links };
      });
      setAttributes({ categories: next });
    };
    const addLink = (catIndex) => {
      const next = categories.map((cat, i) =>
        i === catIndex
          ? {
              ...cat,
              links: [...cat.links, { label: "New Service", url: "/" }],
            }
          : cat,
      );
      setAttributes({ categories: next });
    };
    const removeLink = (catIndex, linkIndex) => {
      const next = categories.map((cat, i) =>
        i === catIndex
          ? { ...cat, links: cat.links.filter((_, j) => j !== linkIndex) }
          : cat,
      );
      setAttributes({ categories: next });
    };

    return (
      <section {...blockProps}>
        <div className="container-custom w-full">
          <div className="max-w-3xl mb-16">
            <RichText
              tagName="span"
              className="text-overline-lg text-secondary mb-4 block"
              value={eyebrow}
              onChange={(value) => setAttributes({ eyebrow: value })}
              allowedFormats={[]}
            />
            <RichText
              tagName="h2"
              className="text-h1 text-white"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
              allowedFormats={[]}
            />
          </div>
          <div className="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            {categories.map((category, catIndex) => (
              <div
                key={catIndex}
                className="bg-white p-8 flex flex-col border-t-4 border-secondary"
              >
                <RichText
                  tagName="h3"
                  className="text-h3 text-[#001b35] mb-4"
                  value={category.title}
                  onChange={(value) => updateCategory(catIndex, "title", value)}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="p"
                  className="text-body-sm text-on-surface-variant mb-8"
                  value={category.description}
                  onChange={(value) =>
                    updateCategory(catIndex, "description", value)
                  }
                  allowedFormats={["core/bold", "core/italic"]}
                />
                <div>
                  <h4 className="text-overline text-secondary mb-4">
                    Specific Services
                  </h4>
                  <div className="flex flex-col gap-2">
                    {category.links.map((link, linkIndex) => (
                      <div
                        key={linkIndex}
                        className="flex items-center gap-2 p-3 bg-[#fcf9f8]"
                      >
                        <TextControl
                          value={link.label}
                          onChange={(value) =>
                            updateLink(catIndex, linkIndex, "label", value)
                          }
                          className="flex-1"
                          __next40pxDefaultSize
                          __nextHasNoMarginBottom
                        />
                        <TextControl
                          value={link.url}
                          onChange={(value) =>
                            updateLink(catIndex, linkIndex, "url", value)
                          }
                          className="flex-1"
                          __next40pxDefaultSize
                          __nextHasNoMarginBottom
                        />
                        <ArrowRight />
                        <Button
                          isDestructive
                          isSmall
                          onClick={() => removeLink(catIndex, linkIndex)}
                        >
                          ×
                        </Button>
                      </div>
                    ))}
                  </div>
                  <Button
                    variant="secondary"
                    className="mt-3"
                    onClick={() => addLink(catIndex)}
                  >
                    + Add link
                  </Button>
                </div>
                <Button
                  isDestructive
                  variant="tertiary"
                  className="mt-4"
                  onClick={() => removeCategory(catIndex)}
                >
                  Remove category
                </Button>
              </div>
            ))}
          </div>
          <div className="mt-8">
            <Button variant="primary" onClick={addCategory}>
              + Add category
            </Button>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
