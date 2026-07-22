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
    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
    <circle cx="9" cy="7" r="4" />
    <path d="M22 21v-2a4 4 0 0 0-3-3.9" />
    <path d="M16 3.1a4 4 0 0 1 0 7.8" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, clients } = attributes;
    const blockProps = useBlockProps({
      className:
        "w-full relative bg-white py-10 md:py-16 border-b border-black/5",
    });

    const updateClient = (index, value) => {
      const next = [...clients];
      next[index] = value;
      setAttributes({ clients: next });
    };
    const removeClient = (index) =>
      setAttributes({ clients: clients.filter((_, i) => i !== index) });
    const addClient = () =>
      setAttributes({ clients: [...clients, "NEW CLIENT"] });

    return (
      <section {...blockProps}>
        <div className="container-custom w-full">
          <div className="text-center mb-12">
            <RichText
              tagName="span"
              className="text-overline-lg text-secondary mb-4 block"
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
          <div className="flex flex-wrap justify-center items-center gap-12 md:gap-24 opacity-60 grayscale">
            {clients.map((client, index) => (
              <div key={index} className="relative group">
                <RichText
                  tagName="div"
                  className="text-2xl font-bold font-mono text-primary"
                  value={client}
                  onChange={(value) => updateClient(index, value)}
                  allowedFormats={[]}
                />
                <Button
                  className="absolute -top-4 -right-4 opacity-0 group-hover:opacity-100"
                  isDestructive
                  isSmall
                  onClick={() => removeClient(index)}
                >
                  ×
                </Button>
              </div>
            ))}
          </div>
          <div className="text-center mt-6">
            <Button variant="secondary" onClick={addClient}>
              + Add client
            </Button>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
