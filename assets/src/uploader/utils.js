const Utils = {
    mimeType(extension = 'bin') {
        if (extension[0] === ".") {
            extension = extension.substring(1);
        }
        const map = this.parseMimeListSingle();

        return map[extension];
    },

    parseMimeListSingle() {
        const raw = this.raw();
        const map = {};
        const lines = raw.split(/\r?\n/);

        for (let line of lines) {
            line = line.trim();
            if (!line || line.startsWith('#')) continue;

            const m = line.match(/^([^\t]+?)\s+\t?\s*(.+)?$/);
            if (!m) continue;

            const mime = m[1].trim().toLowerCase();
            const extsPart = (m[2] || '').trim();
            if (!extsPart) continue;

            for (const rawExt of extsPart.split(',')) {
                let ext = rawExt.trim().toLowerCase();
                if (!ext) continue;
                ext = ext.replace(/^\./, '');

                if (!(ext in map)) {
                    map[ext] = mime;
                }
            }
        }
        return map;
    },

    raw() {
        return `
            application/andrew-inset\t.ez
            application/applixware\t.aw
            application/atom+xml\t.atom
            application/atomcat+xml\t.atomcat
            application/atomsvc+xml\t.atomsvc
            application/ccxml+xml\t.ccxml
            application/cu-seeme\t.cu
            application/davmount+xml\t.davmount
            application/ecmascript\t.ecma
            application/emma+xml\t.emma
            application/epub+zip\t.epub
            application/font-tdpfr\t.pfr
            application/gzip\t.gz, .tgz
            application/hyperstudio\t.stk
            application/java-archive\t.jar
            application/java-serialized-object\t.ser
            application/java-vm\t.class
            application/json\t.json
            application/lost+xml\t.lostxml
            application/mac-binhex40\t.hqx
            application/mac-compactpro\t.cpt
            application/marc\t.mrc
            application/mathematica\t.ma, .mb, .nb
            application/mathml+xml\t.mathml, .mml
            application/mbox\t.mbox
            application/mediaservercontrol+xml\t.mscml
            application/mp4\t.mp4s
            application/msword\t.doc, .dot, .wiz
            application/mxf\t.mxf
            application/octet-stream\t.a, .bin, .bpk, .deploy, .dist, .distz, .dmg, .dms, .dump, .elc, .lha, .lrf, .lzh, .o, .obj, .pkg, .so
            application/oda\t.oda
            application/oebps-package+xml\t.opf
            application/ogg\t.ogx
            application/onenote\t.onepkg, .onetmp, .onetoc, .onetoc2
            application/patch-ops-error+xml\t.xer
            application/pdf\t.pdf
            application/pgp-encrypted\t.pgp
            application/pgp-signature\t.asc, .sig
            application/pics-rules\t.prf
            application/pkcs10\t.p10
            application/pkcs7-mime\t.p7c, .p7m
            application/pkcs7-signature\t.p7s
            application/pkix-cert\t.cer
            application/pkix-crl\t.crl
            application/pkix-pkipath\t.pkipath
            application/pkixcmp\t.pki
            application/pls+xml\t.pls
            application/postscript\t.ai, .eps, .ps
            application/prql\t.prql
            application/prs.cww\t.cww
            application/rdf+xml\t.rdf
            application/reginfo+xml\t.rif
            application/relax-ng-compact-syntax\t.rnc
            application/resource-lists+xml\t.rl
            application/resource-lists-diff+xml\t.rld
            application/rls-services+xml\t.rs
            application/rsd+xml\t.rsd
            application/rss+xml\t.rss, .xml
            application/rtf\t.rtf
            application/sbml+xml\t.sbml
            application/scvp-cv-request\t.scq
            application/scvp-cv-response\t.scs
            application/scvp-vp-request\t.spq
            application/scvp-vp-response\t.spp
            application/sdp\t.sdp
            application/set-payment-initiation\t.setpay
            application/set-registration-initiation\t.setreg
            application/shf+xml\t.shf
            application/smil+xml\t.smi, .smil
            application/sparql-query\t.rq
            application/sparql-results+xml\t.srx
            application/srgs\t.gram
            application/srgs+xml\t.grxml
            application/ssml+xml\t.ssml
            application/vnd.3gpp.pic-bw-large\t.plb
            application/vnd.3gpp.pic-bw-small\t.psb
            application/vnd.3gpp.pic-bw-var\t.pvb
            application/vnd.3gpp2.tcap\t.tcap
            application/vnd.3m.post-it-notes\t.pwn
            application/vnd.accpac.simply.aso\t.aso
            application/vnd.accpac.simply.imp\t.imp
            application/vnd.acucobol\t.acu
            application/vnd.acucorp\t.acutc, .atc
            application/vnd.adobe.air-application-installer-package+zip\t.air
            application/vnd.adobe.xdp+xml\t.xdp
            application/vnd.adobe.xfdf\t.xfdf
            application/vnd.airzip.filesecure.azf\t.azf
            application/vnd.airzip.filesecure.azs\t.azs
            application/vnd.amazon.ebook\t.azw
            application/vnd.americandynamics.acc\t.acc
            application/vnd.amiga.ami\t.ami
            application/vnd.android.package-archive\t.apk
            application/vnd.anser-web-certificate-issue-initiation\t.cii
            application/vnd.anser-web-funds-transfer-initiation\t.fti
            application/vnd.antix.game-component\t.atx
            application/vnd.apple.installer+xml\t.mpkg
            application/vnd.arastra.swi\t.swi
            application/vnd.audiograph\t.aep
            application/vnd.blueice.multipass\t.mpm
            application/vnd.bmi\t.bmi
            application/vnd.businessobjects\t.rep
            application/vnd.chemdraw+xml\t.cdxml
            application/vnd.chipnuts.karaoke-mmd\t.mmd
            application/vnd.cinderella\t.cdy
            application/vnd.claymore\t.cla
            application/vnd.clonk.c4group\t.c4d, .c4f, .c4g, .c4p, .c4u
            application/vnd.commonspace\t.csp
            application/vnd.contact.cmsg\t.cdbcmsg
            application/vnd.cosmocaller\t.cmc
            application/vnd.crick.clicker\t.clkx
            application/vnd.crick.clicker.keyboard\t.clkk
            application/vnd.crick.clicker.palette\t.clkp
            application/vnd.crick.clicker.template\t.clkt
            application/vnd.crick.clicker.wordbank\t.clkw
            application/vnd.criticaltools.wbs+xml\t.wbs
            application/vnd.ctc-posml\t.pml
            application/vnd.cups-ppd\t.ppd
            application/vnd.curl.car\t.car
            application/vnd.curl.pcurl\t.pcurl
            application/vnd.data-vision.rdz\t.rdz
            application/vnd.debian.binary-package\t.deb, .udeb
            application/vnd.denovo.fcselayout-link\t.fe_launch
            application/vnd.dna\t.dna
            application/vnd.dolby.mlp\t.mlp
            application/vnd.dpgraph\t.dpg
            application/vnd.dreamfactory\t.dfac
            application/vnd.dynageo\t.geo
            application/vnd.ecowin.chart\t.mag
            application/vnd.enliven\t.nml
            application/vnd.epson.esf\t.esf
            application/vnd.epson.msf\t.msf
            application/vnd.epson.quickanime\t.qam
            application/vnd.epson.salt\t.slt
            application/vnd.epson.ssf\t.ssf
            application/vnd.eszigno3+xml\t.es3, .et3
            application/vnd.ezpix-album\t.ez2
            application/vnd.ezpix-package\t.ez3
            application/vnd.fdf\t.fdf
            application/vnd.fdsn.mseed\t.mseed
            application/vnd.fdsn.seed\t.dataless, .seed
            application/vnd.flographit\t.gph
            application/vnd.fluxtime.clip\t.ftc
            application/vnd.framemaker\t.book, .fm, .frame, .maker
            application/vnd.frogans.fnc\t.fnc
            application/vnd.frogans.ltf\t.ltf
            application/vnd.fsc.weblaunch\t.fsc
            application/vnd.fujitsu.oasys\t.oas
            application/vnd.fujitsu.oasys2\t.oa2
            application/vnd.fujitsu.oasys3\t.oa3
            application/vnd.fujitsu.oasysgp\t.fg5
            application/vnd.fujitsu.oasysprs\t.bh2
            application/vnd.fujixerox.ddd\t.ddd
            application/vnd.fujixerox.docuworks\t.xdw
            application/vnd.fujixerox.docuworks.binder\t.xbd
            application/vnd.fuzzysheet\t.fzs
            application/vnd.genomatix.tuxedo\t.txd
            application/vnd.geogebra.file\t.ggb
            application/vnd.geogebra.tool\t.ggt
            application/vnd.geometry-explorer\t.gex, .gre
            application/vnd.gerber\t.gbr
            application/vnd.gmx\t.gmx
            application/vnd.google-earth.kml+xml\t.kml
            application/vnd.google-earth.kmz\t.kmz
            application/vnd.grafeq\t.gqf, .gqs
            application/vnd.groove-account\t.gac
            application/vnd.groove-help\t.ghf
            application/vnd.groove-identity-message\t.gim
            application/vnd.groove-injector\t.grv
            application/vnd.groove-tool-message\t.gtm
            application/vnd.groove-tool-template\t.tpl
            application/vnd.groove-vcard\t.vcg
            application/vnd.handheld-entertainment+xml\t.zmm
            application/vnd.hbci\t.hbci
            application/vnd.hhe.lesson-player\t.les
            application/vnd.hp-hpgl\t.hpgl
            application/vnd.hp-hpid\t.hpid
            application/vnd.hp-hps\t.hps
            application/vnd.hp-jlyt\t.jlt
            application/vnd.hp-pcl\t.pcl
            application/vnd.hp-pclxl\t.pclxl
            application/vnd.hydrostatix.sof-data\t.sfd-hdstx
            application/vnd.hzn-3d-crossword\t.x3d
            application/vnd.ibm.minipay\t.mpy
            application/vnd.ibm.modcap\t.afp, .list3820, .listafp
            application/vnd.ibm.rights-management\t.irm
            application/vnd.ibm.secure-container\t.sc
            application/vnd.iccprofile\t.icc, .icm
            application/vnd.igloader\t.igl
            application/vnd.immervision-ivp\t.ivp
            application/vnd.immervision-ivu\t.ivu
            application/vnd.intercon.formnet\t.xpw, .xpx
            application/vnd.intu.qbo\t.qbo
            application/vnd.intu.qfx\t.qfx
            application/vnd.ipunplugged.rcprofile\t.rcprofile
            application/vnd.irepository.package+xml\t.irp
            application/vnd.is-xpr\t.xpr
            application/vnd.jam\t.jam
            application/vnd.jcp.javame.midlet-rms\t.rms
            application/vnd.jisp\t.jisp
            application/vnd.joost.joda-archive\t.joda
            application/vnd.kahootz\t.ktr, .ktz
            application/vnd.kde.karbon\t.karbon
            application/vnd.kde.kchart\t.chrt
            application/vnd.kde.kformula\t.kfo
            application/vnd.kde.kivio\t.flw
            application/vnd.kde.kontour\t.kon
            application/vnd.kde.kpresenter\t.kpr, .kpt
            application/vnd.kde.kspread\t.ksp
            application/vnd.kde.kword\t.kwd, .kwt
            application/vnd.kenameaapp\t.htke
            application/vnd.kidspiration\t.kia
            application/vnd.kinar\t.kne, .knp
            application/vnd.koan\t.skd, .skm, .skp, .skt
            application/vnd.kodak-descriptor\t.sse
            application/vnd.llamagraphics.life-balance.desktop\t.lbd
            application/vnd.llamagraphics.life-balance.exchange+xml\t.lbe
            application/vnd.lotus-1-2-3\t.123
            application/vnd.lotus-approach\t.apr
            application/vnd.lotus-freelance\t.pre
            application/vnd.lotus-notes\t.nsf
            application/vnd.lotus-organizer\t.org
            application/vnd.lotus-screencam\t.scm
            application/vnd.lotus-wordpro\t.lwp
            application/vnd.macports.portpkg\t.portpkg
            application/vnd.mcd\t.mcd
            application/vnd.medcalcdata\t.mc1
            application/vnd.mediastation.cdkey\t.cdkey
            application/vnd.mfer\t.mwf
            application/vnd.mfmp\t.mfm
            application/vnd.micrografx.flo\t.flo
            application/vnd.micrografx.igx\t.igx
            application/vnd.mif\t.mif
            application/vnd.mobius.daf\t.daf
            application/vnd.mobius.dis\t.dis
            application/vnd.mobius.mbk\t.mbk
            application/vnd.mobius.mqy\t.mqy
            application/vnd.mobius.msl\t.msl
            application/vnd.mobius.plc\t.plc
            application/vnd.mobius.txf\t.txf
            application/vnd.mophun.application\t.mpn
            application/vnd.mophun.certificate\t.mpc
            application/vnd.mozilla.xul+xml\t.xul
            application/vnd.ms-artgalry\t.cil
            application/vnd.ms-cab-compressed\t.cab
            application/vnd.ms-excel\t.xla, .xlb, .xlc, .xlm, .xls, .xlt, .xlw
            application/vnd.ms-excel.addin.macroenabled.12\t.xlam
            application/vnd.ms-excel.sheet.binary.macroenabled.12\t.xlsb
            application/vnd.ms-excel.sheet.macroenabled.12\t.xlsm
            application/vnd.ms-excel.template.macroenabled.12\t.xltm
            application/vnd.ms-fontobject\t.eot
            application/vnd.ms-htmlhelp\t.chm
            application/vnd.ms-ims\t.ims
            application/vnd.ms-lrm\t.lrm
            application/vnd.ms-pki.seccat\t.cat
            application/vnd.ms-pki.stl\t.stl
            application/vnd.ms-powerpoint\t.pot, .ppa, .pps, .ppt, .pwz
            application/vnd.ms-powerpoint.addin.macroenabled.12\t.ppam
            application/vnd.ms-powerpoint.presentation.macroenabled.12\t.pptm
            application/vnd.ms-powerpoint.slide.macroenabled.12\t.sldm
            application/vnd.ms-powerpoint.slideshow.macroenabled.12\t.ppsm
            application/vnd.ms-powerpoint.template.macroenabled.12\t.potm
            application/vnd.ms-project\t.mpp, .mpt
            application/vnd.ms-word.document.macroenabled.12\t.docm
            application/vnd.ms-word.template.macroenabled.12\t.dotm
            application/vnd.ms-works\t.wcm, .wdb, .wks, .wps
            application/vnd.ms-wpl\t.wpl
            application/vnd.ms-xpsdocument\t.xps
            application/vnd.mseq\t.mseq
            application/vnd.musician\t.mus
            application/vnd.muvee.style\t.msty
            application/vnd.neurolanguage.nlu\t.nlu
            application/vnd.noblenet-directory\t.nnd
            application/vnd.noblenet-sealer\t.nns
            application/vnd.noblenet-web\t.nnw
            application/vnd.nokia.n-gage.data\t.ngdat
            application/vnd.nokia.n-gage.symbian.install\t.n-gage
            application/vnd.nokia.radio-preset\t.rpst
            application/vnd.nokia.radio-presets\t.rpss
            application/vnd.novadigm.edm\t.edm
            application/vnd.novadigm.edx\t.edx
            application/vnd.novadigm.ext\t.ext
            application/vnd.oasis.opendocument.chart\t.odc
            application/vnd.oasis.opendocument.chart-template\t.otc
            application/vnd.oasis.opendocument.database\t.odb
            application/vnd.oasis.opendocument.formula\t.odf
            application/vnd.oasis.opendocument.formula-template\t.odft
            application/vnd.oasis.opendocument.graphics\t.odg
            application/vnd.oasis.opendocument.graphics-template\t.otg
            application/vnd.oasis.opendocument.image\t.odi
            application/vnd.oasis.opendocument.image-template\t.oti
            application/vnd.oasis.opendocument.presentation\t.odp
            application/vnd.oasis.opendocument.presentation-template\t.otp
            application/vnd.oasis.opendocument.spreadsheet\t.ods
            application/vnd.oasis.opendocument.spreadsheet-template\t.ots
            application/vnd.oasis.opendocument.text\t.odt
            application/vnd.oasis.opendocument.text-master\t.otm
            application/vnd.oasis.opendocument.text-template\t.ott
            application/vnd.oasis.opendocument.text-web\t.oth
            application/vnd.olpc-sugar\t.xo
            application/vnd.oma.dd2+xml\t.dd2
            application/vnd.openofficeorg.extension\t.oxt
            application/vnd.openxmlformats-officedocument.presentationml.presentation\t.pptx
            application/vnd.openxmlformats-officedocument.presentationml.slide\t.sldx
            application/vnd.openxmlformats-officedocument.presentationml.slideshow\t.ppsx
            application/vnd.openxmlformats-officedocument.presentationml.template\t.potx
            application/vnd.openxmlformats-officedocument.spreadsheetml.sheet\t.xlsx
            application/vnd.openxmlformats-officedocument.spreadsheetml.template\t.xltx
            application/vnd.openxmlformats-officedocument.wordprocessingml.document\t.docx
            application/vnd.openxmlformats-officedocument.wordprocessingml.template\t.dotx
            application/vnd.osgi.dp\t.dp
            application/vnd.palm\t.oprc, .pdb, .pqa
            application/vnd.pg.format\t.str
            application/vnd.pg.osasli\t.ei6
            application/vnd.picsel\t.efif
            application/vnd.pocketlearn\t.plf
            application/vnd.powerbuilder6\t.pbd
            application/vnd.previewsystems.box\t.box
            application/vnd.proteus.magazine\t.mgz
            application/vnd.publishare-delta-tree\t.qps
            application/vnd.pvi.ptid1\t.ptid
            application/vnd.quark.quarkxpress\t.qwd, .qwt, .qxb, .qxd, .qxl, .qxt
            application/vnd.rar\t.rar
            application/vnd.recordare.musicxml\t.mxl
            application/vnd.recordare.musicxml+xml\t.musicxml
            application/vnd.rim.cod\t.cod
            application/vnd.rn-realmedia\t.rm
            application/vnd.route66.link66+xml\t.link66
            application/vnd.seemail\t.see
            application/vnd.sema\t.sema
            application/vnd.semd\t.semd
            application/vnd.semf\t.semf
            application/vnd.shana.informed.formdata\t.ifm
            application/vnd.shana.informed.formtemplate\t.itp
            application/vnd.shana.informed.interchange\t.iif
            application/vnd.shana.informed.package\t.ipk
            application/vnd.simtech-mindmapper\t.twd, .twds
            application/vnd.smaf\t.mmf
            application/vnd.smart.teacher\t.teacher
            application/vnd.solent.sdkm+xml\t.sdkd, .sdkm
            application/vnd.spotfire.dxp\t.dxp
            application/vnd.spotfire.sfs\t.sfs
            application/vnd.sqlite3\t.db, .sqlite, .sqlite3, .db-wal, .sqlite-wal, .db-shm, .sqlite-shm
            application/vnd.stardivision.calc\t.sdc
            application/vnd.stardivision.draw\t.sda
            application/vnd.stardivision.impress\t.sdd
            application/vnd.stardivision.math\t.smf
            application/vnd.stardivision.writer\t.sdw, .vor
            application/vnd.stardivision.writer-global\t.sgl
            application/vnd.sun.xml.calc\t.sxc
            application/vnd.sun.xml.calc.template\t.stc
            application/vnd.sun.xml.draw\t.sxd
            application/vnd.sun.xml.draw.template\t.std
            application/vnd.sun.xml.impress\t.sxi
            application/vnd.sun.xml.impress.template\t.sti
            application/vnd.sun.xml.math\t.sxm
            application/vnd.sun.xml.writer\t.sxw
            application/vnd.sun.xml.writer.global\t.sxg
            application/vnd.sun.xml.writer.template\t.stw
            application/vnd.sus-calendar\t.sus, .susp
            application/vnd.svd\t.svd
            application/vnd.symbian.install\t.sis, .sisx
            application/vnd.syncml+xml\t.xsm
            application/vnd.syncml.dm+wbxml\t.bdm
            application/vnd.syncml.dm+xml\t.xdm
            application/vnd.tao.intent-module-archive\t.tao
            application/vnd.tmobile-livetv\t.tmo
            application/vnd.trid.tpt\t.tpt
            application/vnd.triscape.mxs\t.mxs
            application/vnd.trueapp\t.tra
            application/vnd.ufdl\t.ufd, .ufdl
            application/vnd.uiq.theme\t.utz
            application/vnd.umajin\t.umj
            application/vnd.unity\t.unityweb
            application/vnd.uoml+xml\t.uoml
            application/vnd.vcx\t.vcx
            application/vnd.visio\t.vsd, .vss, .vst, .vsw, .vsdx, .vssx, .vstx, .vssm, .vstm
            application/vnd.visionary\t.vis
            application/vnd.vsf\t.vsf
            application/vnd.wap.sic\t.sic
            application/vnd.wap.slc\t.slc
            application/vnd.wap.wbxml\t.wbxml
            application/vnd.wap.wmlc\t.wmlc
            application/vnd.wap.wmlscriptc\t.wmlsc
            application/vnd.webturbo\t.wtb
            application/vnd.wordperfect\t.wpd
            application/vnd.wqd\t.wqd
            application/vnd.wt.stf\t.stf
            application/vnd.xara\t.xar
            application/vnd.xfdl\t.xfdl
            application/vnd.yamaha.hv-dic\t.hvd
            application/vnd.yamaha.hv-script\t.hvs
            application/vnd.yamaha.hv-voice\t.hvp
            application/vnd.yamaha.openscoreformat\t.osf
            application/vnd.yamaha.openscoreformat.osfpvg+xml\t.osfpvg
            application/vnd.yamaha.smaf-audio\t.saf
            application/vnd.yamaha.smaf-phrase\t.spf
            application/vnd.yellowriver-custom-menu\t.cmp
            application/vnd.zul\t.zir, .zirz
            application/vnd.zzazz.deck+xml\t.zaz
            application/voicexml+xml\t.vxml
            application/wasm\t.wasm
            application/winhlp\t.hlp
            application/wsdl+xml\t.wsdl
            application/wspolicy+xml\t.wspolicy
            application/x-7z-compressed\t.7z
            application/x-abiword\t.abw, .zabw, .abw.gz
            application/x-ace-compressed\t.ace
            application/x-authorware-bin\t.aab, .u32, .vox, .x32
            application/x-authorware-map\t.aam
            application/x-authorware-seg\t.aas
            application/x-bcpio\t.bcpio
            application/x-bittorrent\t.torrent
            application/x-bzip\t.bz
            application/x-bzip2\t.boz, .bz2
            application/x-cdlink\t.vcd
            application/x-chat\t.chat
            application/x-chess-pgn\t.pgn
            application/x-cpio\t.cpio
            application/x-csh\t.csh
            application/x-debian-package\t.deb, .udeb
            application/x-director\t.cct, .cst, .cxt, .dcr, .dir, .dxr, .fgd, .swa, .w3d
            application/x-doom\t.wad
            application/x-dtbncx+xml\t.ncx
            application/x-dtbook+xml\t.dtb
            application/x-dtbresource+xml\t.res
            application/x-dvi\t.dvi
            application/x-font-bdf\t.bdf
            application/x-font-ghostscript\t.gsf
            application/x-font-linux-psf\t.psf
            application/x-font-otf\t.otf
            application/x-font-pcf\t.pcf
            application/x-font-snf\t.snf
            application/x-font-ttf\t.ttc, .ttf
            application/x-font-type1\t.afm, .pfa, .pfb, .pfm
            application/x-futuresplash\t.spl
            application/x-gnumeric\t.gnumeric
            application/x-gtar\t.gtar
            application/x-gzip\t.gz, .tgz
            application/x-hdf\t.hdf
            application/x-iso9660-image\t.iso, .isoimg, .cdr
            application/x-java-jnlp-file\t.jnlp
            application/x-killustrator\t.kil
            application/x-krita\t.kra, .krz
            application/x-latex\t.latex
            application/x-mobipocket-ebook\t.mobi, .prc
            application/x-ms-application\t.application
            application/x-ms-wmd\t.wmd
            application/x-ms-wmz\t.wmz
            application/x-ms-xbap\t.xbap
            application/x-msaccess\t.mdb
            application/x-msbinder\t.obd
            application/x-mscardfile\t.crd
            application/x-msclip\t.clp
            application/x-msdownload\t.bat, .com, .dll, .exe, .msi
            application/x-msmediaview\t.m13, .m14, .mvb
            application/x-msmetafile\t.wmf
            application/x-msmoney\t.mny
            application/x-mspublisher\t.pub
            application/x-msschedule\t.scd
            application/x-msterminal\t.trm
            application/x-mswrite\t.wri
            application/x-netcdf\t.cdf, .nc
            application/x-perl\t.pm, .pl
            application/x-pkcs12\t.p12, .pfx
            application/x-pkcs7-certificates\t.p7b, .spc
            application/x-pkcs7-certreqresp\t.p7r
            application/x-rar-compressed\t.rar
            application/x-redhat-package-manager\t.rpa
            application/x-rpm\t.rpm
            application/x-sh\t.sh
            application/x-shar\t.shar
            application/x-shellscript\t.sh
            application/x-shockwave-flash\t.swf
            application/x-silverlight-app\t.xap
            application/x-stuffit\t.sit
            application/x-stuffitx\t.sitx
            application/x-sv4cpio\t.sv4cpio
            application/x-sv4crc\t.sv4crc
            application/x-tar\t.tar
            application/x-tcl\t.tcl
            application/x-tex\t.tex
            application/x-tex-tfm\t.tfm
            application/x-texinfo\t.texi, .texinfo
            application/x-trash\t
            application/x-ustar\t.ustar
            application/x-wais-source\t.src
            application/x-x509-ca-cert\t.crt, .der
            application/x-xfig\t.fig
            application/x-xpinstall\t.xpi
            application/x-zip-compressed\t.zip
            application/xenc+xml\t.xenc
            application/xhtml+xml\t.xht, .xhtml
            application/xml\t.xml, .xpdl, .xsl
            application/xml-dtd\t.dtd
            application/xop+xml\t.xop
            application/xslt+xml\t.xslt
            application/xspf+xml\t.xspf
            application/xv+xml\t.mxml, .xhvml, .xvm, .xvml
            application/yaml\t.yaml, .yml
            application/zip\t.zip
            application/zip-compressed\t.zip
            audio/3gpp2\t.3g2
            audio/aac\t.aac, .m4a
            audio/aacp\t.aacp
            audio/adpcm\t.adp
            audio/aiff\t.aiff, .aif, .aff
            audio/x-aiff
            audio/basic\t.au, .snd
            audio/flac\t.flac
            audio/midi\t.kar, .mid, .midi, .rmi
            audio/mp4\t.mp4, .m4a, .m4b, .m4p, .m4r, .m4v, .mp4v, .3gp, .3g2, .3ga, .3gpa, .3gpp, .3gpp2, .3gp2
            audio/mp4a-latm\t
            audio/mpeg\t.m2a, .m3a, .mp2, .mp2a, .mp3, .mpga
            audio/ogg\t.oga, .ogg, .spx
            audio/opus\t.opus
            audio/vnd.digital-winds\t.eol
            audio/vnd.dts\t.dts
            audio/vnd.dts.hd\t.dtshd
            audio/vnd.lucent.voice\t.lvp
            audio/vnd.ms-playready.media.pya\t.pya
            audio/vnd.nuera.ecelp4800\t.ecelp4800
            audio/vnd.nuera.ecelp7470\t.ecelp7470
            audio/vnd.nuera.ecelp9600\t.ecelp9600
            audio/vnd.wav\t.wav
            audio/wav
            audio/x-wav
            audio/vnd.wave
            audio/wave
            audio/x-pn-wav
            audio/webm\t.weba
            audio/x-matroska\t.mka
            audio/x-mpegurl\t.m3u
            audio/x-ms-wax\t.wax
            audio/x-ms-wma\t.wma
            audio/x-pn-realaudio\t.ra, .ram
            audio/x-pn-realaudio-plugin\t.rmp
            chemical/x-cdx\t.cdx
            chemical/x-cif\t.cif
            chemical/x-cmdf\t.cmdf
            chemical/x-cml\t.cml
            chemical/x-csml\t.csml
            chemical/x-xyz\t.xyz
            font/otf\t.otf
            font/woff\t.woff
            font/woff2\t.woff2
            gcode\t.gcode
            image/avif\t.avif
            image/avif-sequence\t.avifs
            image/bmp\t.bmp
            image/cgm\t.cgm
            image/g3fax\t.g3
            image/gif\t.gif
            image/heic\t.heif, .heic
            image/ief\t.ief
            image/jpeg\t.jpe, .jpeg, .jpg, .pjpg, .jfif, .jfif-tbnl, .jif
            image/pjpeg\t.jpe, .jpeg, .jpg, .pjpg, .jfi, .jfif, .jfif-tbnl, .jif
            image/png\t.png
            image/prs.btif\t.btif
            image/svg+xml\t.svg, .svgz
            image/tiff\t.tif, .tiff
            image/vnd.adobe.photoshop\t.psd
            image/vnd.djvu\t.djv, .djvu
            image/vnd.dwg\t.dwg
            image/vnd.dxf\t.dxf
            image/vnd.fastbidsheet\t.fbs
            image/vnd.fpx\t.fpx
            image/vnd.fst\t.fst
            image/vnd.fujixerox.edmics-mmr\t.mmr
            image/vnd.fujixerox.edmics-rlc\t.rlc
            image/vnd.ms-modi\t.mdi
            image/vnd.net-fpx\t.npx
            image/vnd.wap.wbmp\t.wbmp
            image/vnd.xiff\t.xif
            image/webp\t.webp
            image/x-adobe-dng\t.dng
            image/x-canon-cr2\t.cr2
            image/x-canon-crw\t.crw
            image/x-cmu-raster\t.ras
            image/x-cmx\t.cmx
            image/x-epson-erf\t.erf
            image/x-freehand\t.fh, .fh4, .fh5, .fh7, .fhc
            image/x-fuji-raf\t.raf
            image/x-icns\t.icns
            image/x-icon\t.ico
            image/x-kodak-dcr\t.dcr
            image/x-kodak-k25\t.k25
            image/x-kodak-kdc\t.kdc
            image/x-minolta-mrw\t.mrw
            image/x-nikon-nef\t.nef
            image/x-olympus-orf\t.orf
            image/x-panasonic-raw\t.raw, .rw2, .rwl
            image/x-pcx\t.pcx
            image/x-pentax-pef\t.pef, .ptx
            image/x-pict\t.pct, .pic
            image/x-portable-anymap\t.pnm
            image/x-portable-bitmap\t.pbm
            image/x-portable-graymap\t.pgm
            image/x-portable-pixmap\t.ppm
            image/x-rgb\t.rgb
            image/x-sigma-x3f\t.x3f
            image/x-sony-arw\t.arw
            image/x-sony-sr2\t.sr2
            image/x-sony-srf\t.srf
            image/x-xbitmap\t.xbm
            image/x-xpixmap\t.xpm
            image/x-xwindowdump\t.xwd
            message/rfc822\t.eml, .mht, .mhtml, .mime, .nws
            model/iges\t.iges, .igs
            model/mesh\t.mesh, .msh, .silo
            model/vnd.dwf\t.dwf
            model/vnd.gdl\t.gdl
            model/vnd.gtw\t.gtw
            model/vnd.mts\t.mts
            model/vnd.vtu\t.vtu
            model/vrml\t.vrml, .wrl
            test/mimetype\t.test
            test/mimetype/test
            text/calendar\t.ics, .ifb
            text/css\t.css
            text/csv\t.csv
            text/html\t.htm, .html
            text/javascript\t.js
            text/markdown\t.md, .markdown, .mdown, .markdn
            text/mathml\t.mathml, .mml
            text/plain\t.conf, .def, .diff, .in, .ksh, .list, .log, .pl, .text, .txt
            text/prs.lines.tag\t.dsc
            text/richtext\t.rtx
            text/sgml\t.sgm, .sgml
            text/tab-separated-values\t.tsv
            text/troff\t.man, .me, .ms, .roff, .t, .tr
            text/uri-list\t.uri, .uris, .urls
            text/vnd.curl\t.curl
            text/vnd.curl.dcurl\t.dcurl
            text/vnd.curl.mcurl\t.mcurl
            text/vnd.curl.scurl\t.scurl
            text/vnd.fly\t.fly
            text/vnd.fmi.flexstor\t.flx
            text/vnd.graphviz\t.gv
            text/vnd.in3d.3dml\t.3dml
            text/vnd.in3d.spot\t.spot
            text/vnd.sun.j2me.app-descriptor\t.jad
            text/vnd.wap.si\t.si
            text/vnd.wap.sl\t.sl
            text/vnd.wap.wml\t.wml
            text/vnd.wap.wmlscript\t.wmls
            text/x-asm\t.asm, .s
            text/x-c\t.c, .cc, .cpp, .cxx, .dic, .h, .hh
            text/x-fortran\t.f, .f77, .f90, .for
            text/x-java-source\t.java
            text/x-pascal\t.p, .pas, .pp, .inc
            text/x-python\t.py, .pyc, .pyo, .pyd, .whl
            text/x-setext\t.etx
            text/x-uuencode\t.uu
            text/x-vcalendar\t.vcs
            text/x-vcard\t.vcf
            video/3gpp\t.3gp
            video/3gpp2\t.3g2
            video/h261\t.h261
            video/h263\t.h263
            video/h264\t.h264
            video/jpeg\t.jpgv
            video/jpm\t.jpgm, .jpm
            video/mj2\t.mj2, .mjp2
            video/mp2t\t.ts
            video/mp4\t.mp4, .mp4v, .mpg4
            video/mpeg\t.m1v, .m2v, .mpa, .mpe, .mpeg, .mpg
            video/ogg\t.ogv
            video/quicktime\t.mov, .qt
            video/vnd.fvt\t.fvt
            video/vnd.mpegurl\t.m4u, .mxu
            video/vnd.ms-playready.media.pyv\t.pyv
            video/vnd.vivo\t.viv
            video/webm\t.webm
            video/x-f4v\t.f4v
            video/x-fli\t.fli
            video/x-flv\t.flv
            video/x-m4v\t.m4v
            video/x-matroska\t.mkv
            video/x-ms-asf\t.asf, .asx
            video/x-ms-wm\t.wm
            video/x-ms-wmv\t.wmv
            video/x-ms-wmx\t.wmx
            video/x-ms-wvx\t.wvx
            video/x-msvideo\t.avi
            video/x-sgi-movie\t.movie
            x-conference/x-cooltalk\t.ice
        `;
    }
}

export default Utils;
