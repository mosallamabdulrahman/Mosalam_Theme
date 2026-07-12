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
    <path d="M9 18l6-6-6-6" />
    <circle cx="4" cy="6" r="1" />
    <circle cx="4" cy="12" r="1" />
    <circle cx="4" cy="18" r="1" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { items } = attributes;
    const blockProps = useBlockProps({
      className: "w-36 border border-dashed border-secondary/40 p-4",
    });

    const updateItem = (index, key, value) => {
      const next = items.map((item, i) =>
        i === index ? { ...item, [key]: value } : item,
      );
      setAttributes({ items: next });
    };
    const addItem = () =>
      setAttributes({
        items: [
          ...items,
          { target: "section-id", label: "New Section", tone: "dark" },
        ],
      });
    const removeItem = (index) =>
      setAttributes({ items: items.filter((_, i) => i !== index) });

    return (
      <div {...blockProps}>
        <p className="text-overline text-secondary mb-4">
          Home sticky side nav (visible on desktop only, fixed to the left edge)
        </p>
        <ul className="flex flex-col gap-4">
          {items.map((item, index) => (
            <li key={index} className="border border-black/10 rounded p-2">
              <div className="h-[3px] w-10 bg-[#001b35] mb-2" />
              <RichText
                tagName="span"
                className="text-[11px] font-bold block mb-1"
                value={item.label}
                onChange={(value) => updateItem(index, "label", value)}
                allowedFormats={[]}
              />
              <TextControl
                label="Target section id"
                value={item.target}
                onChange={(value) => updateItem(index, "target", value)}
                __next40pxDefaultSize
                __nextHasNoMarginBottom
              />
              <Button isDestructive isSmall onClick={() => removeItem(index)}>
                Remove
              </Button>
            </li>
          ))}
        </ul>
        <Button variant="secondary" className="mt-3" onClick={addItem}>
          + Add item
        </Button>
      </div>
    );
  },
  save: () => null,
});
