import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
  MediaUpload,
  MediaUploadCheck,
} from "@wordpress/block-editor";
import { PanelBody, Button } from "@wordpress/components";
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
    <rect x="4" y="4" width="16" height="16" rx="2" />
    <rect x="9" y="9" width="6" height="6" />
    <path d="M9 2v2M15 2v2M9 20v2M15 20v2M2 9h2M2 15h2M20 9h2M20 15h2" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, description, backgroundImage, features } =
      attributes;
    const blockProps = useBlockProps({
      className:
        "min-h-screen w-full relative cinematic-section text-white py-10 md:py-16",
    });

    const updateFeature = (index, key, value) => {
      const next = features.map((f, i) =>
        i === index ? { ...f, [key]: value } : f,
      );
      setAttributes({ features: next });
    };

    return (
      <>
        <InspectorControls>
          <PanelBody title="Background">
            <MediaUploadCheck>
              <MediaUpload
                onSelect={(media) =>
                  setAttributes({ backgroundImage: media.url })
                }
                allowedTypes={["image"]}
                render={({ open }) => (
                  <Button variant="secondary" onClick={open}>
                    Choose background image
                  </Button>
                )}
              />
            </MediaUploadCheck>
          </PanelBody>
        </InspectorControls>
        <section {...blockProps}>
          <div className="cinematic-bg">
            <img
              className="w-full h-full object-cover"
              alt="digital matrix background"
              src={backgroundImage}
              referrerPolicy="no-referrer"
            />
            <div className="absolute inset-0 bg-primary/90"></div>
          </div>
          <div className="cinematic-content container-custom w-full">
            <div className="max-w-3xl">
              <RichText
                tagName="span"
                className="text-overline-lg text-secondary-fixed mb-6 block"
                value={eyebrow}
                onChange={(value) => setAttributes({ eyebrow: value })}
                allowedFormats={[]}
              />
              <RichText
                tagName="h2"
                className="text-h1 mb-8"
                value={title}
                onChange={(value) => setAttributes({ title: value })}
                allowedFormats={[]}
              />
              <RichText
                tagName="p"
                className="text-body-lg text-white/70 mb-10 md:mb-16"
                value={description}
                onChange={(value) => setAttributes({ description: value })}
                allowedFormats={["core/bold", "core/italic"]}
              />
              <div className="flex flex-col gap-12">
                <div className="grid grid-cols-1 md:grid-cols-3 gap-12">
                  {features.map((feature, index) => (
                    <div key={index} className="border-l border-white/20 pl-8">
                      <RichText
                        tagName="h3"
                        className="text-h4 mb-4"
                        value={feature.title}
                        onChange={(value) =>
                          updateFeature(index, "title", value)
                        }
                        allowedFormats={[]}
                      />
                      <RichText
                        tagName="p"
                        className="text-body-sm text-white/50"
                        value={feature.description}
                        onChange={(value) =>
                          updateFeature(index, "description", value)
                        }
                        allowedFormats={["core/bold", "core/italic"]}
                      />
                    </div>
                  ))}
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
