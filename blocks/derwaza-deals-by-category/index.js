import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, InspectorControls, MediaUpload, MediaUploadCheck } from '@wordpress/block-editor';
import { PanelBody, TextControl, Button } from '@wordpress/components';
import metadata from './block.json';

const icon = (
  <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" strokeWidth="2" strokeLinecap="round" strokeLinejoin="round">
    <rect width="8" height="4" x="2" y="4" rx="1" />
    <rect width="8" height="4" x="2" y="16" rx="1" />
    <rect width="8" height="4" x="14" y="10" rx="1" />
    <path d="M6 8v8" />
    <path d="M18 14v6" />
    <path d="M14 6h8" />
  </svg>
);

registerBlockType(metadata.name, {
  icon,
  edit: ({ attributes, setAttributes }) => {
    const {
      col1Title, col1Subtitle, col1BtnLabel, col1BtnUrl, col1Image,
      col2Title, col2Subtitle, col2BtnLabel, col2BtnUrl, col2Image,
      col3Title, col3Subtitle, col3BtnLabel, col3BtnUrl, col3Image
    } = attributes;

    const blockProps = useBlockProps({
      className: 'derwaza-deals-editor w-full max-w-[1400px] mx-auto py-6 px-4 md:px-6',
    });

    const themeUrl = window.mosalamThemeUrl || '';
    const def1 = themeUrl + '/assets/images/portfolio/tech-strip-default.png';
    const def2 = themeUrl + '/assets/images/portfolio/beauty-strip-default.png';
    const def3 = themeUrl + '/assets/images/portfolio/kitchen-strip-default.png';

    const renderColumnInspector = (
      num, title, subtitle, btnLabel, btnUrl, image,
      setTitleKey, setSubKey, setBtnLabelKey, setBtnUrlKey, setImgKey
    ) => (
      <PanelBody title={`Column #${num} Settings`} initialOpen={num === 1}>
        <TextControl
          label="Title"
          value={title}
          onChange={(val) => setAttributes({ [setTitleKey]: val })}
        />
        <TextControl
          label="Subtitle"
          value={subtitle}
          onChange={(val) => setAttributes({ [setSubKey]: val })}
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
          <span className="block text-xs font-semibold mb-2 text-gray-600 font-sans">Products Strip Image</span>
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
            1, col1Title, col1Subtitle, col1BtnLabel, col1BtnUrl, col1Image,
            'col1Title', 'col1Subtitle', 'col1BtnLabel', 'col1BtnUrl', 'col1Image'
          )}
          {renderColumnInspector(
            2, col2Title, col2Subtitle, col2BtnLabel, col2BtnUrl, col2Image,
            'col2Title', 'col2Subtitle', 'col2BtnLabel', 'col2BtnUrl', 'col2Image'
          )}
          {renderColumnInspector(
            3, col3Title, col3Subtitle, col3BtnLabel, col3BtnUrl, col3Image,
            'col3Title', 'col3Subtitle', 'col3BtnLabel', 'col3BtnUrl', 'col3Image'
          )}
        </InspectorControls>

        <div {...blockProps}>
          <div className="grid grid-cols-1 md:grid-cols-3 gap-6 font-sans">
            
            {/* Column 1 */}
            <div className="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] min-h-[180px]">
              <div className="flex justify-between items-start w-full gap-4">
                <div>
                  <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    {col1Title || 'Deals by Category'}
                  </h3>
                  <p className="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                    {col1Subtitle || 'Top offers on electronics'}
                  </p>
                </div>
                <a 
                  href={col1BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm flex-shrink-0"
                >
                  {col1BtnLabel || 'View All'}
                </a>
              </div>
              <div className="w-full h-[80px] mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                  src={col1Image || def1} 
                  className="absolute w-full h-[240px] max-w-none object-contain pointer-events-none" 
                  style={{ top: '50%', transform: 'translateY(-50%)' }}
                  alt="" 
                />
              </div>
            </div>

            {/* Column 2 */}
            <div className="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] min-h-[180px]">
              <div className="flex justify-between items-start w-full gap-4">
                <div>
                  <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    {col2Title || 'Beauty Deals'}
                  </h3>
                  <p className="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                    {col2Subtitle || 'Best beauty offers'}
                  </p>
                </div>
                <a 
                  href={col2BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm flex-shrink-0"
                >
                  {col2BtnLabel || 'View All'}
                </a>
              </div>
              <div className="w-full h-[80px] mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                  src={col2Image || def2} 
                  className="absolute w-full h-[240px] max-w-none object-contain pointer-events-none" 
                  style={{ top: '50%', transform: 'translateY(-50%)' }}
                  alt="" 
                />
              </div>
            </div>

            {/* Column 3 */}
            <div className="bg-white border border-[#eceef1] rounded-[24px] p-6 flex flex-col justify-between shadow-[0_8px_30px_rgb(0,0,0,0.06)] min-h-[180px]">
              <div className="flex justify-between items-start w-full gap-4">
                <div>
                  <h3 className="text-lg md:text-xl font-extrabold text-[#111111] leading-tight m-0">
                    {col3Title || 'Home & Kitchen Deals'}
                  </h3>
                  <p className="text-[13px] md:text-sm text-gray-500 font-medium mt-1 mb-0">
                    {col3Subtitle || 'Great home deals'}
                  </p>
                </div>
                <a 
                  href={col3BtnUrl || '#'} 
                  onClick={(e) => e.preventDefault()}
                  className="inline-flex items-center justify-center bg-white border border-[#d1d5db] text-xs font-bold text-[#1b1c1c] px-4 py-1.5 rounded-full shadow-sm flex-shrink-0"
                >
                  {col3BtnLabel || 'View All'}
                </a>
              </div>
              <div className="w-full h-[80px] mt-4 relative overflow-hidden flex items-center justify-center bg-white rounded-xl">
                <img 
                  src={col3Image || def3} 
                  className="absolute w-full h-[240px] max-w-none object-contain pointer-events-none" 
                  style={{ top: '50%', transform: 'translateY(-50%)' }}
                  alt="" 
                />
              </div>
            </div>

          </div>
        </div>
      </>
    );
  },
  save: () => null,
});
