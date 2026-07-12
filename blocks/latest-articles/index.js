import { registerBlockType } from "@wordpress/blocks";
import {
  useBlockProps,
  RichText,
  InspectorControls,
} from "@wordpress/block-editor";
import {
  PanelBody,
  RangeControl,
  TextControl,
  Spinner,
} from "@wordpress/components";
import { useSelect } from "@wordpress/data";
import { store as coreStore } from "@wordpress/core-data";
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
    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20" />
    <path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2Z" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const { eyebrow, title, postsToShow, viewAllLabel } = attributes;
    const blockProps = useBlockProps({
      className: "py-10 md:py-16 bg-surface border-t border-black/5",
    });

    const posts = useSelect(
      (select) =>
        select(coreStore).getEntityRecords("postType", "post", {
          per_page: postsToShow,
          _embed: true,
          status: "publish",
        }),
      [postsToShow],
    );

    const getFeaturedImage = (post) =>
      post._embedded?.["wp:featuredmedia"]?.[0]?.source_url || "";

    return (
      <>
        <InspectorControls>
          <PanelBody title="Latest Articles Settings">
            <RangeControl
              label="Posts to show"
              value={postsToShow}
              onChange={(value) => setAttributes({ postsToShow: value })}
              min={1}
              max={6}
              __next40pxDefaultSize
              __nextHasNoMarginBottom
            />
            <TextControl
              label='"View all" link label'
              value={viewAllLabel}
              onChange={(value) => setAttributes({ viewAllLabel: value })}
              __next40pxDefaultSize
              __nextHasNoMarginBottom
            />
          </PanelBody>
        </InspectorControls>
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

            <div className="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-2 md:gap-4">
              {!posts && (
                <div className="col-span-full flex justify-center py-12">
                  <Spinner />
                </div>
              )}
              {posts && posts.length === 0 && (
                <p className="col-span-full text-body text-on-surface-variant">
                  No published posts yet — the latest posts will appear here
                  automatically once you publish some.
                </p>
              )}
              {posts &&
                posts.map((post) => (
                  <div
                    key={post.id}
                    className="flex flex-col bg-white rounded-action border border-outline-variant/20 overflow-hidden shadow-sm"
                  >
                    <div className="aspect-[16/10] overflow-hidden bg-gradient-to-br from-surface-container to-surface-dim flex items-center justify-center">
                      {getFeaturedImage(post) ? (
                        <img
                          src={getFeaturedImage(post)}
                          alt=""
                          className="w-full h-full object-cover"
                        />
                      ) : (
                        <span className="text-4xl text-outline-variant/40">
                          ✦
                        </span>
                      )}
                    </div>
                    <div className="flex flex-col flex-1 p-6 md:p-7">
                      {/* eslint-disable-next-line react/no-danger */}
                      <h3
                        className="text-h4 text-primary mb-3 line-clamp-2"
                        dangerouslySetInnerHTML={{
                          __html: post.title?.rendered || "(no title)",
                        }}
                      />
                      {/* eslint-disable-next-line react/no-danger */}
                      <div
                        className="text-body-sm text-on-surface-variant line-clamp-3 flex-1"
                        dangerouslySetInnerHTML={{
                          __html: post.excerpt?.rendered || "",
                        }}
                      />
                    </div>
                  </div>
                ))}
            </div>
          </div>
        </section>
      </>
    );
  },
  save: () => null,
});
