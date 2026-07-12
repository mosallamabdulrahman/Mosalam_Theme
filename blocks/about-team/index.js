import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  MediaUpload,
  MediaUploadCheck,
} from "@wordpress/block-editor";
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
    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
    <circle cx="9" cy="7" r="4" />
    <path d="M23 21v-2a4 4 0 0 0-3-3.9" />
    <path d="M16 3.1a4 4 0 0 1 0 7.8" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, members } = attributes;
    const blockProps = useBlockProps({
      className:
        "py-10 md:py-16 bg-surface-container-low border-t border-black/5",
    });

    const updateMember = (index, key, value) => {
      const next = members.map((m, i) =>
        i === index ? { ...m, [key]: value } : m,
      );
      setAttributes({ members: next });
    };
    const addMember = () =>
      setAttributes({
        members: [...members, { name: "New Member", role: "Role", image: "" }],
      });
    const removeMember = (index) =>
      setAttributes({ members: members.filter((_, i) => i !== index) });

    return (
      <section {...blockProps}>
        <div className="container-custom">
          <div className="flex flex-col md:flex-row justify-between items-start md:items-end mb-16 gap-4">
            <RichText
              tagName="h2"
              className="text-h2 text-primary"
              value={title}
              onChange={(value) => setAttributes({ title: value })}
              allowedFormats={[]}
            />
            <RichText
              tagName="span"
              className="text-secondary font-bold uppercase tracking-[0.2em] text-xs"
              value={eyebrow}
              onChange={(value) => setAttributes({ eyebrow: value })}
              allowedFormats={[]}
            />
          </div>
          <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            {members.map((member, index) => {
              const imageUrl =
                member.image &&
                !(
                  member.image.startsWith("http://") ||
                  member.image.startsWith("https://") ||
                  member.image.startsWith("/")
                )
                  ? `${window.mosalamThemeUrl || ""}/${member.image}`
                  : member.image;

              return (
                <div
                  key={index}
                  className="group bg-white shadow-sm overflow-hidden relative"
                >
                  <div className="aspect-[4/5] overflow-hidden bg-black/5 relative">
                    <img
                      className="w-full h-full object-cover grayscale"
                      alt={member.name}
                      src={imageUrl}
                      referrerPolicy="no-referrer"
                    />
                    <MediaUploadCheck>
                      <MediaUpload
                        onSelect={(media) =>
                          updateMember(index, "image", media.url)
                        }
                        allowedTypes={["image"]}
                        render={({ open }) => (
                          <Button
                            variant="secondary"
                            className="absolute bottom-2 left-2"
                            onClick={open}
                          >
                            Change photo
                          </Button>
                        )}
                      />
                    </MediaUploadCheck>
                  </div>
                  <div className="p-6">
                    <RichText
                      tagName="h4"
                      className="text-h4 text-primary mb-1"
                      value={member.name}
                      onChange={(value) => updateMember(index, "name", value)}
                      allowedFormats={[]}
                    />
                    <RichText
                      tagName="p"
                      className="text-secondary text-[10px] font-bold uppercase tracking-widest"
                      value={member.role}
                      onChange={(value) => updateMember(index, "role", value)}
                      allowedFormats={[]}
                    />
                  </div>
                  <Button
                    isDestructive
                    isSmall
                    className="absolute top-2 right-2"
                    onClick={() => removeMember(index)}
                  >
                    ×
                  </Button>
                </div>
              );
            })}
          </div>
          <div className="mt-8">
            <Button variant="secondary" onClick={addMember}>
              + Add team member
            </Button>
          </div>
        </div>
      </section>
    );
  },
  save: () => null,
});
