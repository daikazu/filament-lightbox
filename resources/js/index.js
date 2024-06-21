import fslightbox from 'fslightbox';

window.fslightbox = fslightbox;


window.FilamentLightBox = {
    getViewerURL(url) {
        // https://gist.github.com/theel0ja/b9e44a961f892ccf43e217ab74b9417b
        // Extract the file extension
        let extension = url.split('.').pop();

        switch (extension) {
            case 'pdf':
                return `https://docs.google.com/viewer?url=${url}&embedded=true`;
            case 'doc':
            case 'docx':
            case 'xls':
            case 'xlsx':
            case 'ppt':
            case 'pptx':
                return `https://view.officeapps.live.com/op/embed.aspx?src=${url}`;
            default:
                return url;
        }
    },
    getMultipleImgURL(element) {

        try {
            if (element != undefined && element != null) {
                let imgArr = element?.closest('div')?.querySelectorAll('img.filament-light-box-img-indicator');
                if (imgArr != undefined && Array.from(imgArr).length > 0) {
                    return Array.from(imgArr, (imgElm) => imgElm.getAttribute('src'));
                }
            }
        } catch (error) {
            //
        }

        return null;
    },
    createIframe(url) {
        // Create a new iframe element
        document.getElementById("tmp-iframe")?.remove();
        let iframe = document.createElement('iframe');
        iframe.src = this.getViewerURL(url);
        iframe.id = "tmp-iframe";
        iframe.className = "fslightbox-source";
        iframe.frameBorder = "0";
        iframe.allow = "autoplay; fullscreen";
        iframe.style = "width: 80vw; height: 80vh;";
        iframe.setAttribute("allowFullScreen", "");
        document.body.appendChild(iframe);
    },
    getType(url) {
         if (url.match(/\.(mp4|webm|ogg)$/)) {
            return "video";
        } else if (url.match(/(youtube\.com|youtu\.be)/)) {
            return "youtube";
        } else {
            return "image";
        }
    },
    open(e, url) {
        e.preventDefault();
        const lightbox = new FsLightbox();
        const type = this.getType(url);
        if (url !== undefined) {


            if (url !== this.getViewerURL(url)) {
                this.createIframe(url);
                lightbox.props.sources = [document.getElementById("tmp-iframe")];
                lightbox.props.type = type;
                lightbox.props.onClose = function (instance) {
                    document.getElementById("tmp-iframe")?.remove();
                }
                lightbox.open();
                return;
            }
        }

        // Multiple images
        let multipleURL = this.getMultipleImgURL(e.target);
        if (multipleURL != null && multipleURL.length > 0) {
            lightbox.props.sources = multipleURL;
            lightbox.props.type = "image";
            lightbox.open();
            return;
        }

        if (e.target.src !== undefined) {
            lightbox.props.sources = [e.target.src];
            lightbox.props.type = type;
            lightbox.open();
        }
    }
}
