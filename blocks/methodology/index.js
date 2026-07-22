import { registerBlockType } from "@wordpress/blocks";
import { useBlockProps, RichText } from "@wordpress/block-editor";
import { Button } from "@wordpress/components";
import { useState } from "@wordpress/element";
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
    <path d="M9 11H3l1-8h5" />
    <path d="M9 21h6" />
    <path d="M12 3h9l-1 8h-8" />
    <path d="M9 3v18" />
    <path d="M15 3v8" />
  </svg>
);

const imageUrl = (filename) =>
  `${window.mosalamThemeUrl || ""}/assets/images/${filename}`;

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, description, steps } = attributes;
    const [activeTab, setActiveTab] = useState(0);
    const blockProps = useBlockProps({
      className:
        "min-h-screen w-full relative cinematic-section bg-[#fcf9f8] py-10 md:py-16",
    });
    const active = steps[activeTab] || steps[0];

    const updateStep = (index, key, value) => {
      const next = steps.map((step, i) =>
        i === index ? { ...step, [key]: value } : step,
      );
      setAttributes({ steps: next });
    };
    const addStep = () => {
      const n = steps.length + 1;
      setAttributes({
        steps: [
          ...steps,
          {
            number: String(n).padStart(2, "0"),
            title: "New Step",
            description: "Step description.",
            image: "discover.webp",
          },
        ],
      });
    };
    const removeStep = (index) => {
      setAttributes({ steps: steps.filter((_, i) => i !== index) });
      if (activeTab >= steps.length - 1) setActiveTab(0);
    };

    return (
      <section {...blockProps}>
        <div className="container-custom w-full">
          <div className="max-w-3xl mb-16">
            <RichText
              tagName="span"
              className="text-overline-lg text-secondary mb-6 block"
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

          <div className="w-full overflow-x-auto hide-scrollbar mb-12 border-b border-black/10">
            <div className="flex w-max min-w-full">
              {steps.map((step, index) => (
                <button
                  type="button"
                  key={index}
                  onClick={() => setActiveTab(index)}
                  className={`min-w-[180px] md:min-w-[200px] flex-1 text-center pb-4 text-h4 transition-all duration-300 relative ${
                    activeTab === index
                      ? "text-primary"
                      : "text-on-surface-variant/50 hover:text-primary/70"
                  }`}
                >
                  <span className="text-secondary mr-2 text-sm align-top">
                    {step.number}
                  </span>
                  {step.title}
                  {activeTab === index && (
                    <span className="absolute bottom-0 left-0 w-full h-1 bg-secondary" />
                  )}
                </button>
              ))}
            </div>
          </div>

          <div className="bg-white shadow-xl border border-black/5 rounded-action overflow-hidden">
            <div className="flex flex-col md:flex-row min-h-[400px]">
              <div className="w-full md:w-1/2 p-12 flex flex-col justify-center">
                <span className="block text-h1 text-secondary/20 mb-4 font-mono">
                  {active.number}
                </span>
                <RichText
                  tagName="h3"
                  className="text-h2 text-primary mb-6"
                  value={active.title}
                  onChange={(value) => updateStep(activeTab, "title", value)}
                  allowedFormats={[]}
                />
                <RichText
                  tagName="p"
                  className="text-body-lg text-on-surface-variant leading-relaxed"
                  value={active.description}
                  onChange={(value) =>
                    updateStep(activeTab, "description", value)
                  }
                  allowedFormats={["core/bold", "core/italic"]}
                />
                <Button
                  className="mt-6"
                  isDestructive
                  variant="tertiary"
                  onClick={() => removeStep(activeTab)}
                  disabled={steps.length <= 1}
                >
                  Remove this step
                </Button>
              </div>
              <div className="w-full md:w-1/2 h-64 md:h-auto relative overflow-hidden">
                <img
                  src={imageUrl(active.image)}
                  alt={active.title}
                  className="w-full h-full object-cover"
                  referrerPolicy="no-referrer"
                />
                <div className="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
              </div>
            </div>
          </div>
          <div className="mt-6">
            <Button variant="secondary" onClick={addStep}>
              + Add step
            </Button>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
