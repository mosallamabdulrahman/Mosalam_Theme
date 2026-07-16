import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button, TextareaControl } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <rect width="7" height="9" x="3" y="3" rx="1" />
    <rect width="7" height="5" x="14" y="3" rx="1" />
    <rect width="7" height="9" x="14" y="12" rx="1" />
    <rect width="7" height="5" x="3" y="16" rx="1" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const {
      col1Title, col1Desc, col1BtnLabel, col1BtnUrl, col1Image,
      col2Title, col2Desc, col2BtnLabel, col2BtnUrl, col2Image,
      col3Title, col3Desc, col3BtnLabel, col3BtnUrl, col3Image
    } = attributes;

    const blockProps = useBlockProps({
      className: 'derwaza-collections-editor w-full max-w-[1400px] mx-auto py-6 px-4 md:px-6',
    });

    const themeUrl = window.mosalamThemeUrl || '';
    const def1 = themeUrl + '/assets/images/portfolio/tech-collection-default.png';
    const def2 = themeUrl + '/assets/images/portfolio/beauty-collection-default.png';
    const def3 = themeUrl + '/assets/images/portfolio/kitchen-collection-default.png';

    const renderColumnInspector = (num, title, desc, btnLabel, btnUrl, image, setImgKey, setTitleKey, setDescKey, setBtnLabelKey, setBtnUrlKey) => (
      <PanelBody title={`Column #${num} Settings`} initialOpen={num === 1}>
        <TextControl
          label="Title"
          value={title}
          onChange={(val) => setAttributes({ [setTitleKey]: val })}
        />
        <TextareaControl
          label="Description"
          value={desc}
          onChange={(val) => setAttributes({ [setDescKey]: val })}
          rows={3}
        />
        <div style={{ display: 'flex', gap: '8px' }}>
          <div style={{ flex: 1 }}>
            <TextControl
              label="Button Label"
              value={btnLabel}
              onChange={(val) => setAttributes({ [setBtnLabelKey]: val })}
            />
          </div>
          <div style={{ flex: 2 }}>
            <TextControl
              label="Button Link URL"
              value={btnUrl}
              onChange={(val) => setAttributes({ [setBtnUrlKey]: val })}
            />
          </div>
        </div>

        <div className="mb-4">
          <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Card Image</span>
          <MediaUploadCheck>
            <MediaUpload
              onSelect={(media) => setAttributes({ [setImgKey]: media.url })}
              allowedTypes={['image']}
              value={image}
              render={({ open }) => (
                <div style={{ display: 'flex', gap: '8px', alignItems: 'center' }}>
                  <Button variant="secondary" onClick={open}>
                    Upload/Choose Image
                  </Button>
                  {image && (
                    <Button 
                      variant="link" 
                      isDestructive 
                      onClick={() => setAttributes({ [setImgKey]: '' })}
                    >
                      Clear
                    </Button>
                  )}
                </div>
              )}
            />
          </MediaUploadCheck>
          <TextControl
            label="Or Image URL"
            value={image}
            onChange={(val) => setAttributes({ [setImgKey]: val })}
          />
        </div>
      </PanelBody>
    );

    return (
      <>
        <InspectorControls>
          {renderColumnInspector(
            1, col1Title, col1Desc, col1BtnLabel, col1BtnUrl, col1Image,
            'col1Image', 'col1Title', 'col1Desc', 'col1BtnLabel', 'col1BtnUrl'
          )}
          {renderColumnInspector(
            2, col2Title, col2Desc, col2BtnLabel, col2BtnUrl, col2Image,
            'col2Image', 'col2Title', 'col2Desc', 'col2BtnLabel', 'col2BtnUrl'
          )}
          {renderColumnInspector(
            3, col3Title, col3Desc, col3BtnLabel, col3BtnUrl, col3Image,
            'col3Image', 'col3Title', 'col3Desc', 'col3BtnLabel', 'col3BtnUrl'
          )}
        </InspectorControls>

        <div {...blockProps}>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans">
            
            {/* Column 1 */}
            <div 
              className="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center shadow-[0_8px_30px_rgb(0,0,0,0.06)]"
              style={{
                backgroundImage: `url(${col1Image || def1})`,
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right 16px center',
                backgroundSize: '130px auto'
              }}
            >
              <div className="w-[55%] flex flex-col justify-center items-start">
                <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                  {col1Title || 'Collections'}
                </h3>
                <p className="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                  {col1Desc || 'Discover the latest tech. latest/tech.'}
                </p>
                <a 
                  href={col1BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm"
                >
                  {col1BtnLabel || 'View All'}
                </a>
              </div>
            </div>

            {/* Column 2 */}
            <div 
              className="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center shadow-[0_8px_30px_rgb(0,0,0,0.06)]"
              style={{
                backgroundImage: `url(${col2Image || def2})`,
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right 16px center',
                backgroundSize: '130px auto'
              }}
            >
              <div className="w-[55%] flex flex-col justify-center items-start">
                <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                  {col2Title || 'New in Beauty'}
                </h3>
                <p className="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                  {col2Desc || 'Discover the newest beauty products.'}
                </p>
                <a 
                  href={col2BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm"
                >
                  {col2BtnLabel || 'View All'}
                </a>
              </div>
            </div>

            {/* Column 3 */}
            <div 
              className="relative overflow-hidden bg-white border border-[#eceef1] rounded-[24px] p-6 h-[180px] flex flex-col justify-center shadow-[0_8px_30px_rgb(0,0,0,0.06)]"
              style={{
                backgroundImage: `url(${col3Image || def3})`,
                backgroundRepeat: 'no-repeat',
                backgroundPosition: 'right 16px center',
                backgroundSize: '130px auto'
              }}
            >
              <div className="w-[55%] flex flex-col justify-center items-start">
                <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                  {col3Title || 'New in Home & Kitchen'}
                </h3>
                <p className="text-[13px] md:text-sm text-gray-700 font-medium mt-1.5 mb-4 line-clamp-2 min-h-[40px]">
                  {col3Desc || 'Upgrade your home essentials.'}
                </p>
                <a 
                  href={col3BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-5 py-2 rounded-full shadow-sm"
                >
                  {col3BtnLabel || 'View All'}
                </a>
              </div>
            </div>

          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
