<?php

/*
 * This file is a part of the YouTubePHP project.
 *
 * Copyright (c) 2026-present Valithor Obsidion <valithor@valgorithms.com>
 *
 * This file is subject to the MIT license that is bundled
 * with this source code in the LICENSE file.
 */

namespace YouTube\Parts;

/**
 * This file is generated from spec/discovery.json (YouTube Data API v3, revision 20260924) by
 * tools/generate.php. Do not edit it by hand - run `composer spec:build` instead.
 *
 * Ratings schemes. The country-specific ratings are mostly for movies and shows. LINT.IfChange
 *
 * @property string|null $acbRating The video's Australian Classification Board (ACB) or Australian
 *     Communications and Media Authority (ACMA) rating. ACMA ratings are used to classify children's television
 *     programming. One of the `ACB_RATING_*` constants.
 * @property string|null $agcomRating The video's rating from Italy's Autorità per le Garanzie nelle
 *     Comunicazioni (AGCOM). One of the `AGCOM_RATING_*` constants.
 * @property string|null $anatelRating The video's Anatel (Asociación Nacional de Televisión) rating for
 *     Chilean television. One of the `ANATEL_RATING_*` constants.
 * @property string|null $bbfcRating The video's British Board of Film Classification (BBFC) rating. One of the
 *     `BBFC_RATING_*` constants.
 * @property string|null $bfvcRating The video's rating from Thailand's Board of Film and Video Censors. One of
 *     the `BFVC_RATING_*` constants.
 * @property string|null $bmukkRating The video's rating from the Austrian Board of Media Classification
 *     (Bundesministerium für Unterricht, Kunst und Kultur). One of the `BMUKK_RATING_*` constants.
 * @property string|null $catvRating Rating system for Canadian TV - Canadian TV Classification System The
 *     video's rating from the Canadian Radio-Television and Telecommunications Commission (CRTC) for Canadian
 *     English-language broadcasts. For more information, see the Canadian Broadcast Standards Council website. One
 *     of the `CATV_RATING_*` constants.
 * @property string|null $catvfrRating The video's rating from the Canadian Radio-Television and
 *     Telecommunications Commission (CRTC) for Canadian French-language broadcasts. For more information, see the
 *     Canadian Broadcast Standards Council website. One of the `CATVFR_RATING_*` constants.
 * @property string|null $cbfcRating The video's Central Board of Film Certification (CBFC - India) rating. One
 *     of the `CBFC_RATING_*` constants.
 * @property string|null $cccRating The video's Consejo de Calificación Cinematográfica (Chile) rating. One of
 *     the `CCC_RATING_*` constants.
 * @property string|null $cceRating The video's rating from Portugal's Comissão de Classificação de
 *     Espect´culos. One of the `CCE_RATING_*` constants.
 * @property string|null $chfilmRating The video's rating in Switzerland. One of the `CHFILM_RATING_*` constants.
 * @property string|null $chvrsRating The video's Canadian Home Video Rating System (CHVRS) rating. One of the
 *     `CHVRS_RATING_*` constants.
 * @property string|null $cicfRating The video's rating from the Commission de Contrôle des Films (Belgium). One
 *     of the `CICF_RATING_*` constants.
 * @property string|null $cnaRating The video's rating from Romania's CONSILIUL NATIONAL AL AUDIOVIZUALULUI
 *     (CNA). One of the `CNA_RATING_*` constants.
 * @property string|null $cncRating Rating system in France - Commission de classification cinematographique One
 *     of the `CNC_RATING_*` constants.
 * @property string|null $csaRating The video's rating from France's Conseil supérieur de l’audiovisuel, which
 *     rates broadcast content. One of the `CSA_RATING_*` constants.
 * @property string|null $cscfRating The video's rating from Luxembourg's Commission de surveillance de la
 *     classification des films (CSCF). One of the `CSCF_RATING_*` constants.
 * @property string|null $czfilmRating The video's rating in the Czech Republic. One of the `CZFILM_RATING_*`
 *     constants.
 * @property string|null $djctqRating The video's Departamento de Justiça, Classificação, Qualificação e
 *     Títulos (DJCQT - Brazil) rating. One of the `DJCTQ_RATING_*` constants.
 * @property list<string>|null $djctqRatingReasons Reasons that explain why the video received its DJCQT (Brazil)
 *     rating.
 * @property string|null $ecbmctRating Rating system in Turkey - Evaluation and Classification Board of the
 *     Ministry of Culture and Tourism One of the `ECBMCT_RATING_*` constants.
 * @property string|null $eefilmRating The video's rating in Estonia. One of the `EEFILM_RATING_*` constants.
 * @property string|null $egfilmRating The video's rating in Egypt. One of the `EGFILM_RATING_*` constants.
 * @property string|null $eirinRating The video's Eirin (映倫) rating. Eirin is the Japanese rating system. One
 *     of the `EIRIN_RATING_*` constants.
 * @property string|null $fcbmRating The video's rating from Malaysia's Film Censorship Board. One of the
 *     `FCBM_RATING_*` constants.
 * @property string|null $fcoRating The video's rating from Hong Kong's Office for Film, Newspaper and Article
 *     Administration. One of the `FCO_RATING_*` constants.
 * @property string|null $fmocRating Deprecated. This property has been deprecated. Use the
 *     contentDetails.contentRating.cncRating instead. One of the `FMOC_RATING_*` constants.
 * @property string|null $fpbRating The video's rating from South Africa's Film and Publication Board. One of the
 *     `FPB_RATING_*` constants.
 * @property list<string>|null $fpbRatingReasons Reasons that explain why the video received its FPB (South
 *     Africa) rating.
 * @property string|null $fskRating The video's Freiwillige Selbstkontrolle der Filmwirtschaft (FSK - Germany)
 *     rating. One of the `FSK_RATING_*` constants.
 * @property string|null $grfilmRating The video's rating in Greece. One of the `GRFILM_RATING_*` constants.
 * @property string|null $icaaRating The video's Instituto de la Cinematografía y de las Artes Audiovisuales
 *     (ICAA - Spain) rating. One of the `ICAA_RATING_*` constants.
 * @property string|null $ifcoRating The video's Irish Film Classification Office (IFCO - Ireland) rating. See
 *     the IFCO website for more information. One of the `IFCO_RATING_*` constants.
 * @property string|null $ilfilmRating The video's rating in Israel. One of the `ILFILM_RATING_*` constants.
 * @property string|null $incaaRating The video's INCAA (Instituto Nacional de Cine y Artes Audiovisuales -
 *     Argentina) rating. One of the `INCAA_RATING_*` constants.
 * @property string|null $kfcbRating The video's rating from the Kenya Film Classification Board. One of the
 *     `KFCB_RATING_*` constants.
 * @property string|null $kijkwijzerRating The video's NICAM/Kijkwijzer rating from the Nederlands Instituut voor
 *     de Classificatie van Audiovisuele Media (Netherlands). One of the `KIJKWIJZER_RATING_*` constants.
 * @property string|null $kmrbRating The video's Korea Media Rating Board (영상물등급위원회) rating. The
 *     KMRB rates videos in South Korea. One of the `KMRB_RATING_*` constants.
 * @property string|null $lsfRating The video's rating from Indonesia's Lembaga Sensor Film. One of the
 *     `LSF_RATING_*` constants.
 * @property string|null $mccaaRating The video's rating from Malta's Film Age-Classification Board. One of the
 *     `MCCAA_RATING_*` constants.
 * @property string|null $mccypRating The video's rating from the Danish Film Institute's (Det Danske
 *     Filminstitut) Media Council for Children and Young People. One of the `MCCYP_RATING_*` constants.
 * @property string|null $mcstRating The video's rating system for Vietnam - MCST One of the `MCST_RATING_*`
 *     constants.
 * @property string|null $mdaRating The video's rating from Singapore's Media Development Authority (MDA) and,
 *     specifically, it's Board of Film Censors (BFC). One of the `MDA_RATING_*` constants.
 * @property string|null $medietilsynetRating The video's rating from Medietilsynet, the Norwegian Media
 *     Authority. One of the `MEDIETILSYNET_RATING_*` constants.
 * @property string|null $mekuRating The video's rating from Finland's Kansallinen Audiovisuaalinen Instituutti
 *     (National Audiovisual Institute). One of the `MEKU_RATING_*` constants.
 * @property string|null $menaMpaaRating The rating system for MENA countries, a clone of MPAA. It is needed to
 *     prevent titles go live w/o additional QC check, since some of them can be inappropriate for the countries at
 *     all. See b/33408548 for more details. One of the `MENA_MPAA_RATING_*` constants.
 * @property string|null $mibacRating The video's rating from the Ministero dei Beni e delle Attività Culturali
 *     e del Turismo (Italy). One of the `MIBAC_RATING_*` constants.
 * @property string|null $mocRating The video's Ministerio de Cultura (Colombia) rating. One of the
 *     `MOC_RATING_*` constants.
 * @property string|null $moctwRating The video's rating from Taiwan's Ministry of Culture (文化部). One of
 *     the `MOCTW_RATING_*` constants.
 * @property string|null $mpaaRating The video's Motion Picture Association of America (MPAA) rating. One of the
 *     `MPAA_RATING_*` constants.
 * @property string|null $mpaatRating The rating system for trailer, DVD, and Ad in the US. See
 *     http://movielabs.com/md/ratings/v2.3/html/US_MPAAT_Ratings.html. One of the `MPAAT_RATING_*` constants.
 * @property string|null $mtrcbRating The video's rating from the Movie and Television Review and Classification
 *     Board (Philippines). One of the `MTRCB_RATING_*` constants.
 * @property string|null $nbcRating The video's rating from the Maldives National Bureau of Classification. One
 *     of the `NBC_RATING_*` constants.
 * @property string|null $nbcplRating The video's rating in Poland. One of the `NBCPL_RATING_*` constants.
 * @property string|null $nfrcRating The video's rating from the Bulgarian National Film Center. One of the
 *     `NFRC_RATING_*` constants.
 * @property string|null $nfvcbRating The video's rating from Nigeria's National Film and Video Censors Board.
 *     One of the `NFVCB_RATING_*` constants.
 * @property string|null $nkclvRating The video's rating from the Nacionãlais Kino centrs (National Film Centre
 *     of Latvia). One of the `NKCLV_RATING_*` constants.
 * @property string|null $nmcRating The National Media Council ratings system for United Arab Emirates. One of
 *     the `NMC_RATING_*` constants.
 * @property string|null $oflcRating The video's Office of Film and Literature Classification (OFLC - New
 *     Zealand) rating. One of the `OFLC_RATING_*` constants.
 * @property string|null $pefilmRating The video's rating in Peru. One of the `PEFILM_RATING_*` constants.
 * @property string|null $rcnofRating The video's rating from the Hungarian Nemzeti Filmiroda, the Rating
 *     Committee of the National Office of Film. One of the `RCNOF_RATING_*` constants.
 * @property string|null $resorteviolenciaRating The video's rating in Venezuela. One of the
 *     `RESORTEVIOLENCIA_RATING_*` constants.
 * @property string|null $rtcRating The video's General Directorate of Radio, Television and Cinematography
 *     (Mexico) rating. One of the `RTC_RATING_*` constants.
 * @property string|null $rteRating The video's rating from Ireland's Raidió Teilifís Éireann. One of the
 *     `RTE_RATING_*` constants.
 * @property string|null $russiaRating The video's National Film Registry of the Russian Federation (MKRF -
 *     Russia) rating. One of the `RUSSIA_RATING_*` constants.
 * @property string|null $skfilmRating The video's rating in Slovakia. One of the `SKFILM_RATING_*` constants.
 * @property string|null $smaisRating The video's rating in Iceland. One of the `SMAIS_RATING_*` constants.
 * @property string|null $smsaRating The video's rating from Statens medieråd (Sweden's National Media Council).
 *     One of the `SMSA_RATING_*` constants.
 * @property string|null $tvpgRating The video's TV Parental Guidelines (TVPG) rating. One of the `TVPG_RATING_*`
 *     constants.
 * @property string|null $ytRating A rating that YouTube uses to identify age-restricted content. One of the
 *     `YT_RATING_*` constants.
 *
 * @since 1.0.0
 */
class ContentRating extends Part
{
    /** A `acbRating` of `acbUnspecified`. */
    public const ACB_RATING_ACB_UNSPECIFIED = 'acbUnspecified';

    /** E */
    public const ACB_RATING_ACB_E = 'acbE';

    /**
     * Programs that have been given a P classification by the Australian Communications and Media
     * Authority. These programs are intended for preschool children.
     */
    public const ACB_RATING_ACB_P = 'acbP';

    /**
     * Programs that have been given a C classification by the Australian Communications and Media
     * Authority. These programs are intended for children (other than preschool children) who are younger
     * than 14 years of age.
     */
    public const ACB_RATING_ACB_C = 'acbC';

    /** G */
    public const ACB_RATING_ACB_G = 'acbG';

    /** PG */
    public const ACB_RATING_ACB_PG = 'acbPg';

    /** M */
    public const ACB_RATING_ACB_M = 'acbM';

    /** MA15+ */
    public const ACB_RATING_ACB_MA15PLUS = 'acbMa15plus';

    /** R18+ */
    public const ACB_RATING_ACB_R18PLUS = 'acbR18plus';

    /** A `acbRating` of `acbUnrated`. */
    public const ACB_RATING_ACB_UNRATED = 'acbUnrated';

    /** A `agcomRating` of `agcomUnspecified`. */
    public const AGCOM_RATING_AGCOM_UNSPECIFIED = 'agcomUnspecified';

    /** T */
    public const AGCOM_RATING_AGCOM_T = 'agcomT';

    /** VM14 */
    public const AGCOM_RATING_AGCOM_VM14 = 'agcomVm14';

    /** VM18 */
    public const AGCOM_RATING_AGCOM_VM18 = 'agcomVm18';

    /** A `agcomRating` of `agcomUnrated`. */
    public const AGCOM_RATING_AGCOM_UNRATED = 'agcomUnrated';

    /** A `anatelRating` of `anatelUnspecified`. */
    public const ANATEL_RATING_ANATEL_UNSPECIFIED = 'anatelUnspecified';

    /** F */
    public const ANATEL_RATING_ANATEL_F = 'anatelF';

    /** I */
    public const ANATEL_RATING_ANATEL_I = 'anatelI';

    /** I-7 */
    public const ANATEL_RATING_ANATEL_I7 = 'anatelI7';

    /** I-10 */
    public const ANATEL_RATING_ANATEL_I10 = 'anatelI10';

    /** I-12 */
    public const ANATEL_RATING_ANATEL_I12 = 'anatelI12';

    /** R */
    public const ANATEL_RATING_ANATEL_R = 'anatelR';

    /** A */
    public const ANATEL_RATING_ANATEL_A = 'anatelA';

    /** A `anatelRating` of `anatelUnrated`. */
    public const ANATEL_RATING_ANATEL_UNRATED = 'anatelUnrated';

    /** A `bbfcRating` of `bbfcUnspecified`. */
    public const BBFC_RATING_BBFC_UNSPECIFIED = 'bbfcUnspecified';

    /** U */
    public const BBFC_RATING_BBFC_U = 'bbfcU';

    /** PG */
    public const BBFC_RATING_BBFC_PG = 'bbfcPg';

    /** 12A */
    public const BBFC_RATING_BBFC12A = 'bbfc12a';

    /** 12 */
    public const BBFC_RATING_BBFC12 = 'bbfc12';

    /** 15 */
    public const BBFC_RATING_BBFC15 = 'bbfc15';

    /** 18 */
    public const BBFC_RATING_BBFC18 = 'bbfc18';

    /** R18 */
    public const BBFC_RATING_BBFC_R18 = 'bbfcR18';

    /** A `bbfcRating` of `bbfcUnrated`. */
    public const BBFC_RATING_BBFC_UNRATED = 'bbfcUnrated';

    /** A `bfvcRating` of `bfvcUnspecified`. */
    public const BFVC_RATING_BFVC_UNSPECIFIED = 'bfvcUnspecified';

    /** G */
    public const BFVC_RATING_BFVC_G = 'bfvcG';

    /** E */
    public const BFVC_RATING_BFVC_E = 'bfvcE';

    /** 13 */
    public const BFVC_RATING_BFVC13 = 'bfvc13';

    /** 15 */
    public const BFVC_RATING_BFVC15 = 'bfvc15';

    /** 18 */
    public const BFVC_RATING_BFVC18 = 'bfvc18';

    /** 20 */
    public const BFVC_RATING_BFVC20 = 'bfvc20';

    /** B */
    public const BFVC_RATING_BFVC_B = 'bfvcB';

    /** A `bfvcRating` of `bfvcUnrated`. */
    public const BFVC_RATING_BFVC_UNRATED = 'bfvcUnrated';

    /** A `bmukkRating` of `bmukkUnspecified`. */
    public const BMUKK_RATING_BMUKK_UNSPECIFIED = 'bmukkUnspecified';

    /** Unrestricted */
    public const BMUKK_RATING_BMUKK_AA = 'bmukkAa';

    /** 6+ */
    public const BMUKK_RATING_BMUKK6 = 'bmukk6';

    /** 8+ */
    public const BMUKK_RATING_BMUKK8 = 'bmukk8';

    /** 10+ */
    public const BMUKK_RATING_BMUKK10 = 'bmukk10';

    /** 12+ */
    public const BMUKK_RATING_BMUKK12 = 'bmukk12';

    /** 14+ */
    public const BMUKK_RATING_BMUKK14 = 'bmukk14';

    /** 16+ */
    public const BMUKK_RATING_BMUKK16 = 'bmukk16';

    /** A `bmukkRating` of `bmukkUnrated`. */
    public const BMUKK_RATING_BMUKK_UNRATED = 'bmukkUnrated';

    /** A `catvRating` of `catvUnspecified`. */
    public const CATV_RATING_CATV_UNSPECIFIED = 'catvUnspecified';

    /** C */
    public const CATV_RATING_CATV_C = 'catvC';

    /** C8 */
    public const CATV_RATING_CATV_C8 = 'catvC8';

    /** G */
    public const CATV_RATING_CATV_G = 'catvG';

    /** PG */
    public const CATV_RATING_CATV_PG = 'catvPg';

    /** 14+ */
    public const CATV_RATING_CATV14PLUS = 'catv14plus';

    /** 18+ */
    public const CATV_RATING_CATV18PLUS = 'catv18plus';

    /** A `catvRating` of `catvUnrated`. */
    public const CATV_RATING_CATV_UNRATED = 'catvUnrated';

    /** A `catvRating` of `catvE`. */
    public const CATV_RATING_CATV_E = 'catvE';

    /** A `catvfrRating` of `catvfrUnspecified`. */
    public const CATVFR_RATING_CATVFR_UNSPECIFIED = 'catvfrUnspecified';

    /** G */
    public const CATVFR_RATING_CATVFR_G = 'catvfrG';

    /** 8+ */
    public const CATVFR_RATING_CATVFR8PLUS = 'catvfr8plus';

    /** 13+ */
    public const CATVFR_RATING_CATVFR13PLUS = 'catvfr13plus';

    /** 16+ */
    public const CATVFR_RATING_CATVFR16PLUS = 'catvfr16plus';

    /** 18+ */
    public const CATVFR_RATING_CATVFR18PLUS = 'catvfr18plus';

    /** A `catvfrRating` of `catvfrUnrated`. */
    public const CATVFR_RATING_CATVFR_UNRATED = 'catvfrUnrated';

    /** A `catvfrRating` of `catvfrE`. */
    public const CATVFR_RATING_CATVFR_E = 'catvfrE';

    /** A `cbfcRating` of `cbfcUnspecified`. */
    public const CBFC_RATING_CBFC_UNSPECIFIED = 'cbfcUnspecified';

    /** U */
    public const CBFC_RATING_CBFC_U = 'cbfcU';

    /** U/A */
    public const CBFC_RATING_CBFC_UA = 'cbfcUA';

    /** U/A 7+ */
    public const CBFC_RATING_CBFC_UA7PLUS = 'cbfcUA7plus';

    /** U/A 13+ */
    public const CBFC_RATING_CBFC_UA13PLUS = 'cbfcUA13plus';

    /** U/A 16+ */
    public const CBFC_RATING_CBFC_UA16PLUS = 'cbfcUA16plus';

    /** A */
    public const CBFC_RATING_CBFC_A = 'cbfcA';

    /** S */
    public const CBFC_RATING_CBFC_S = 'cbfcS';

    /** A `cbfcRating` of `cbfcUnrated`. */
    public const CBFC_RATING_CBFC_UNRATED = 'cbfcUnrated';

    /** A `cccRating` of `cccUnspecified`. */
    public const CCC_RATING_CCC_UNSPECIFIED = 'cccUnspecified';

    /** Todo espectador */
    public const CCC_RATING_CCC_TE = 'cccTe';

    /** 6+ - Inconveniente para menores de 7 años */
    public const CCC_RATING_CCC6 = 'ccc6';

    /** 14+ */
    public const CCC_RATING_CCC14 = 'ccc14';

    /** 18+ */
    public const CCC_RATING_CCC18 = 'ccc18';

    /** 18+ - contenido excesivamente violento */
    public const CCC_RATING_CCC18V = 'ccc18v';

    /** 18+ - contenido pornográfico */
    public const CCC_RATING_CCC18S = 'ccc18s';

    /** A `cccRating` of `cccUnrated`. */
    public const CCC_RATING_CCC_UNRATED = 'cccUnrated';

    /** A `cceRating` of `cceUnspecified`. */
    public const CCE_RATING_CCE_UNSPECIFIED = 'cceUnspecified';

    /** 4 */
    public const CCE_RATING_CCE_M4 = 'cceM4';

    /** 6 */
    public const CCE_RATING_CCE_M6 = 'cceM6';

    /** 12 */
    public const CCE_RATING_CCE_M12 = 'cceM12';

    /** 16 */
    public const CCE_RATING_CCE_M16 = 'cceM16';

    /** 18 */
    public const CCE_RATING_CCE_M18 = 'cceM18';

    /** A `cceRating` of `cceUnrated`. */
    public const CCE_RATING_CCE_UNRATED = 'cceUnrated';

    /** 14 */
    public const CCE_RATING_CCE_M14 = 'cceM14';

    /** A `chfilmRating` of `chfilmUnspecified`. */
    public const CHFILM_RATING_CHFILM_UNSPECIFIED = 'chfilmUnspecified';

    /** 0 */
    public const CHFILM_RATING_CHFILM0 = 'chfilm0';

    /** 6 */
    public const CHFILM_RATING_CHFILM6 = 'chfilm6';

    /** 12 */
    public const CHFILM_RATING_CHFILM12 = 'chfilm12';

    /** 16 */
    public const CHFILM_RATING_CHFILM16 = 'chfilm16';

    /** 18 */
    public const CHFILM_RATING_CHFILM18 = 'chfilm18';

    /** A `chfilmRating` of `chfilmUnrated`. */
    public const CHFILM_RATING_CHFILM_UNRATED = 'chfilmUnrated';

    /** A `chvrsRating` of `chvrsUnspecified`. */
    public const CHVRS_RATING_CHVRS_UNSPECIFIED = 'chvrsUnspecified';

    /** G */
    public const CHVRS_RATING_CHVRS_G = 'chvrsG';

    /** PG */
    public const CHVRS_RATING_CHVRS_PG = 'chvrsPg';

    /** 14A */
    public const CHVRS_RATING_CHVRS14A = 'chvrs14a';

    /** 18A */
    public const CHVRS_RATING_CHVRS18A = 'chvrs18a';

    /** R */
    public const CHVRS_RATING_CHVRS_R = 'chvrsR';

    /** E */
    public const CHVRS_RATING_CHVRS_E = 'chvrsE';

    /** A `chvrsRating` of `chvrsUnrated`. */
    public const CHVRS_RATING_CHVRS_UNRATED = 'chvrsUnrated';

    /** A `cicfRating` of `cicfUnspecified`. */
    public const CICF_RATING_CICF_UNSPECIFIED = 'cicfUnspecified';

    /** E */
    public const CICF_RATING_CICF_E = 'cicfE';

    /** KT/EA */
    public const CICF_RATING_CICF_KT_EA = 'cicfKtEa';

    /** KNT/ENA */
    public const CICF_RATING_CICF_KNT_ENA = 'cicfKntEna';

    /** A `cicfRating` of `cicfUnrated`. */
    public const CICF_RATING_CICF_UNRATED = 'cicfUnrated';

    /** A `cnaRating` of `cnaUnspecified`. */
    public const CNA_RATING_CNA_UNSPECIFIED = 'cnaUnspecified';

    /** AP */
    public const CNA_RATING_CNA_AP = 'cnaAp';

    /** 12 */
    public const CNA_RATING_CNA12 = 'cna12';

    /** 15 */
    public const CNA_RATING_CNA15 = 'cna15';

    /** 18 */
    public const CNA_RATING_CNA18 = 'cna18';

    /** 18+ */
    public const CNA_RATING_CNA18PLUS = 'cna18plus';

    /** A `cnaRating` of `cnaUnrated`. */
    public const CNA_RATING_CNA_UNRATED = 'cnaUnrated';

    /** A `cncRating` of `cncUnspecified`. */
    public const CNC_RATING_CNC_UNSPECIFIED = 'cncUnspecified';

    /** T */
    public const CNC_RATING_CNC_T = 'cncT';

    /** 10 */
    public const CNC_RATING_CNC10 = 'cnc10';

    /** 12 */
    public const CNC_RATING_CNC12 = 'cnc12';

    /** 16 */
    public const CNC_RATING_CNC16 = 'cnc16';

    /** 18 */
    public const CNC_RATING_CNC18 = 'cnc18';

    /** E */
    public const CNC_RATING_CNC_E = 'cncE';

    /** interdiction */
    public const CNC_RATING_CNC_INTERDICTION = 'cncInterdiction';

    /** A `cncRating` of `cncUnrated`. */
    public const CNC_RATING_CNC_UNRATED = 'cncUnrated';

    /** A `csaRating` of `csaUnspecified`. */
    public const CSA_RATING_CSA_UNSPECIFIED = 'csaUnspecified';

    /** T */
    public const CSA_RATING_CSA_T = 'csaT';

    /** 10 */
    public const CSA_RATING_CSA10 = 'csa10';

    /** 12 */
    public const CSA_RATING_CSA12 = 'csa12';

    /** 16 */
    public const CSA_RATING_CSA16 = 'csa16';

    /** 18 */
    public const CSA_RATING_CSA18 = 'csa18';

    /** Interdiction */
    public const CSA_RATING_CSA_INTERDICTION = 'csaInterdiction';

    /** A `csaRating` of `csaUnrated`. */
    public const CSA_RATING_CSA_UNRATED = 'csaUnrated';

    /** A `cscfRating` of `cscfUnspecified`. */
    public const CSCF_RATING_CSCF_UNSPECIFIED = 'cscfUnspecified';

    /** AL */
    public const CSCF_RATING_CSCF_AL = 'cscfAl';

    /** A */
    public const CSCF_RATING_CSCF_A = 'cscfA';

    /** 6 */
    public const CSCF_RATING_CSCF6 = 'cscf6';

    /** 9 */
    public const CSCF_RATING_CSCF9 = 'cscf9';

    /** 12 */
    public const CSCF_RATING_CSCF12 = 'cscf12';

    /** 16 */
    public const CSCF_RATING_CSCF16 = 'cscf16';

    /** 18 */
    public const CSCF_RATING_CSCF18 = 'cscf18';

    /** A `cscfRating` of `cscfUnrated`. */
    public const CSCF_RATING_CSCF_UNRATED = 'cscfUnrated';

    /** A `czfilmRating` of `czfilmUnspecified`. */
    public const CZFILM_RATING_CZFILM_UNSPECIFIED = 'czfilmUnspecified';

    /** U */
    public const CZFILM_RATING_CZFILM_U = 'czfilmU';

    /** 12 */
    public const CZFILM_RATING_CZFILM12 = 'czfilm12';

    /** 14 */
    public const CZFILM_RATING_CZFILM14 = 'czfilm14';

    /** 18 */
    public const CZFILM_RATING_CZFILM18 = 'czfilm18';

    /** A `czfilmRating` of `czfilmUnrated`. */
    public const CZFILM_RATING_CZFILM_UNRATED = 'czfilmUnrated';

    /** A `djctqRating` of `djctqUnspecified`. */
    public const DJCTQ_RATING_DJCTQ_UNSPECIFIED = 'djctqUnspecified';

    /** L */
    public const DJCTQ_RATING_DJCTQ_L = 'djctqL';

    /** 10 */
    public const DJCTQ_RATING_DJCTQ10 = 'djctq10';

    /** 12 */
    public const DJCTQ_RATING_DJCTQ12 = 'djctq12';

    /** 14 */
    public const DJCTQ_RATING_DJCTQ14 = 'djctq14';

    /** 16 */
    public const DJCTQ_RATING_DJCTQ16 = 'djctq16';

    /** 18 */
    public const DJCTQ_RATING_DJCTQ18 = 'djctq18';

    /** A `djctqRating` of `djctqEr`. */
    public const DJCTQ_RATING_DJCTQ_ER = 'djctqEr';

    /** A `djctqRating` of `djctqL10`. */
    public const DJCTQ_RATING_DJCTQ_L10 = 'djctqL10';

    /** A `djctqRating` of `djctqL12`. */
    public const DJCTQ_RATING_DJCTQ_L12 = 'djctqL12';

    /** A `djctqRating` of `djctqL14`. */
    public const DJCTQ_RATING_DJCTQ_L14 = 'djctqL14';

    /** A `djctqRating` of `djctqL16`. */
    public const DJCTQ_RATING_DJCTQ_L16 = 'djctqL16';

    /** A `djctqRating` of `djctqL18`. */
    public const DJCTQ_RATING_DJCTQ_L18 = 'djctqL18';

    /** A `djctqRating` of `djctq1012`. */
    public const DJCTQ_RATING_DJCTQ1012 = 'djctq1012';

    /** A `djctqRating` of `djctq1014`. */
    public const DJCTQ_RATING_DJCTQ1014 = 'djctq1014';

    /** A `djctqRating` of `djctq1016`. */
    public const DJCTQ_RATING_DJCTQ1016 = 'djctq1016';

    /** A `djctqRating` of `djctq1018`. */
    public const DJCTQ_RATING_DJCTQ1018 = 'djctq1018';

    /** A `djctqRating` of `djctq1214`. */
    public const DJCTQ_RATING_DJCTQ1214 = 'djctq1214';

    /** A `djctqRating` of `djctq1216`. */
    public const DJCTQ_RATING_DJCTQ1216 = 'djctq1216';

    /** A `djctqRating` of `djctq1218`. */
    public const DJCTQ_RATING_DJCTQ1218 = 'djctq1218';

    /** A `djctqRating` of `djctq1416`. */
    public const DJCTQ_RATING_DJCTQ1416 = 'djctq1416';

    /** A `djctqRating` of `djctq1418`. */
    public const DJCTQ_RATING_DJCTQ1418 = 'djctq1418';

    /** A `djctqRating` of `djctq1618`. */
    public const DJCTQ_RATING_DJCTQ1618 = 'djctq1618';

    /** A `djctqRating` of `djctqUnrated`. */
    public const DJCTQ_RATING_DJCTQ_UNRATED = 'djctqUnrated';

    /** A `ecbmctRating` of `ecbmctUnspecified`. */
    public const ECBMCT_RATING_ECBMCT_UNSPECIFIED = 'ecbmctUnspecified';

    /** G */
    public const ECBMCT_RATING_ECBMCT_G = 'ecbmctG';

    /** 7A */
    public const ECBMCT_RATING_ECBMCT7A = 'ecbmct7a';

    /** 7+ */
    public const ECBMCT_RATING_ECBMCT7PLUS = 'ecbmct7plus';

    /** 13A */
    public const ECBMCT_RATING_ECBMCT13A = 'ecbmct13a';

    /** 13+ */
    public const ECBMCT_RATING_ECBMCT13PLUS = 'ecbmct13plus';

    /** 15A */
    public const ECBMCT_RATING_ECBMCT15A = 'ecbmct15a';

    /** 15+ */
    public const ECBMCT_RATING_ECBMCT15PLUS = 'ecbmct15plus';

    /** 18+ */
    public const ECBMCT_RATING_ECBMCT18PLUS = 'ecbmct18plus';

    /** A `ecbmctRating` of `ecbmctUnrated`. */
    public const ECBMCT_RATING_ECBMCT_UNRATED = 'ecbmctUnrated';

    /** A `eefilmRating` of `eefilmUnspecified`. */
    public const EEFILM_RATING_EEFILM_UNSPECIFIED = 'eefilmUnspecified';

    /** Pere */
    public const EEFILM_RATING_EEFILM_PERE = 'eefilmPere';

    /** L */
    public const EEFILM_RATING_EEFILM_L = 'eefilmL';

    /** MS-6 */
    public const EEFILM_RATING_EEFILM_MS6 = 'eefilmMs6';

    /** K-6 */
    public const EEFILM_RATING_EEFILM_K6 = 'eefilmK6';

    /** MS-12 */
    public const EEFILM_RATING_EEFILM_MS12 = 'eefilmMs12';

    /** K-12 */
    public const EEFILM_RATING_EEFILM_K12 = 'eefilmK12';

    /** K-14 */
    public const EEFILM_RATING_EEFILM_K14 = 'eefilmK14';

    /** K-16 */
    public const EEFILM_RATING_EEFILM_K16 = 'eefilmK16';

    /** A `eefilmRating` of `eefilmUnrated`. */
    public const EEFILM_RATING_EEFILM_UNRATED = 'eefilmUnrated';

    /** A `egfilmRating` of `egfilmUnspecified`. */
    public const EGFILM_RATING_EGFILM_UNSPECIFIED = 'egfilmUnspecified';

    /** GN */
    public const EGFILM_RATING_EGFILM_GN = 'egfilmGn';

    /** 18 */
    public const EGFILM_RATING_EGFILM18 = 'egfilm18';

    /** BN */
    public const EGFILM_RATING_EGFILM_BN = 'egfilmBn';

    /** A `egfilmRating` of `egfilmUnrated`. */
    public const EGFILM_RATING_EGFILM_UNRATED = 'egfilmUnrated';

    /** A `eirinRating` of `eirinUnspecified`. */
    public const EIRIN_RATING_EIRIN_UNSPECIFIED = 'eirinUnspecified';

    /** G */
    public const EIRIN_RATING_EIRIN_G = 'eirinG';

    /** PG-12 */
    public const EIRIN_RATING_EIRIN_PG12 = 'eirinPg12';

    /** R15+ */
    public const EIRIN_RATING_EIRIN_R15PLUS = 'eirinR15plus';

    /** R18+ */
    public const EIRIN_RATING_EIRIN_R18PLUS = 'eirinR18plus';

    /** A `eirinRating` of `eirinUnrated`. */
    public const EIRIN_RATING_EIRIN_UNRATED = 'eirinUnrated';

    /** A `fcbmRating` of `fcbmUnspecified`. */
    public const FCBM_RATING_FCBM_UNSPECIFIED = 'fcbmUnspecified';

    /** U */
    public const FCBM_RATING_FCBM_U = 'fcbmU';

    /** PG13 */
    public const FCBM_RATING_FCBM_PG13 = 'fcbmPg13';

    /** P13 */
    public const FCBM_RATING_FCBM_P13 = 'fcbmP13';

    /** 18 */
    public const FCBM_RATING_FCBM18 = 'fcbm18';

    /** 18SX */
    public const FCBM_RATING_FCBM18SX = 'fcbm18sx';

    /** 18PA */
    public const FCBM_RATING_FCBM18PA = 'fcbm18pa';

    /** 18SG */
    public const FCBM_RATING_FCBM18SG = 'fcbm18sg';

    /** 18PL */
    public const FCBM_RATING_FCBM18PL = 'fcbm18pl';

    /** A `fcbmRating` of `fcbmUnrated`. */
    public const FCBM_RATING_FCBM_UNRATED = 'fcbmUnrated';

    /** A `fcoRating` of `fcoUnspecified`. */
    public const FCO_RATING_FCO_UNSPECIFIED = 'fcoUnspecified';

    /** I */
    public const FCO_RATING_FCO_I = 'fcoI';

    /** IIA */
    public const FCO_RATING_FCO_IIA = 'fcoIia';

    /** IIB */
    public const FCO_RATING_FCO_IIB = 'fcoIib';

    /** II */
    public const FCO_RATING_FCO_II = 'fcoIi';

    /** III */
    public const FCO_RATING_FCO_III = 'fcoIii';

    /** A `fcoRating` of `fcoUnrated`. */
    public const FCO_RATING_FCO_UNRATED = 'fcoUnrated';

    /** A `fmocRating` of `fmocUnspecified`. */
    public const FMOC_RATING_FMOC_UNSPECIFIED = 'fmocUnspecified';

    /** U */
    public const FMOC_RATING_FMOC_U = 'fmocU';

    /** 10 */
    public const FMOC_RATING_FMOC10 = 'fmoc10';

    /** 12 */
    public const FMOC_RATING_FMOC12 = 'fmoc12';

    /** 16 */
    public const FMOC_RATING_FMOC16 = 'fmoc16';

    /** 18 */
    public const FMOC_RATING_FMOC18 = 'fmoc18';

    /** E */
    public const FMOC_RATING_FMOC_E = 'fmocE';

    /** A `fmocRating` of `fmocUnrated`. */
    public const FMOC_RATING_FMOC_UNRATED = 'fmocUnrated';

    /** A `fpbRating` of `fpbUnspecified`. */
    public const FPB_RATING_FPB_UNSPECIFIED = 'fpbUnspecified';

    /** A */
    public const FPB_RATING_FPB_A = 'fpbA';

    /** PG */
    public const FPB_RATING_FPB_PG = 'fpbPg';

    /** 7-9PG */
    public const FPB_RATING_FPB79_PG = 'fpb79Pg';

    /** 10-12PG */
    public const FPB_RATING_FPB1012_PG = 'fpb1012Pg';

    /** 13 */
    public const FPB_RATING_FPB13 = 'fpb13';

    /** 16 */
    public const FPB_RATING_FPB16 = 'fpb16';

    /** 18 */
    public const FPB_RATING_FPB18 = 'fpb18';

    /** X18 */
    public const FPB_RATING_FPB_X18 = 'fpbX18';

    /** XX */
    public const FPB_RATING_FPB_XX = 'fpbXx';

    /** A `fpbRating` of `fpbUnrated`. */
    public const FPB_RATING_FPB_UNRATED = 'fpbUnrated';

    /** 10 */
    public const FPB_RATING_FPB10 = 'fpb10';

    /** A `fskRating` of `fskUnspecified`. */
    public const FSK_RATING_FSK_UNSPECIFIED = 'fskUnspecified';

    /** FSK 0 */
    public const FSK_RATING_FSK0 = 'fsk0';

    /** FSK 6 */
    public const FSK_RATING_FSK6 = 'fsk6';

    /** FSK 12 */
    public const FSK_RATING_FSK12 = 'fsk12';

    /** FSK 16 */
    public const FSK_RATING_FSK16 = 'fsk16';

    /** FSK 18 */
    public const FSK_RATING_FSK18 = 'fsk18';

    /** A `fskRating` of `fskUnrated`. */
    public const FSK_RATING_FSK_UNRATED = 'fskUnrated';

    /** A `grfilmRating` of `grfilmUnspecified`. */
    public const GRFILM_RATING_GRFILM_UNSPECIFIED = 'grfilmUnspecified';

    /** K */
    public const GRFILM_RATING_GRFILM_K = 'grfilmK';

    /** E */
    public const GRFILM_RATING_GRFILM_E = 'grfilmE';

    /** K-12 */
    public const GRFILM_RATING_GRFILM_K12 = 'grfilmK12';

    /** K-13 */
    public const GRFILM_RATING_GRFILM_K13 = 'grfilmK13';

    /** K-15 */
    public const GRFILM_RATING_GRFILM_K15 = 'grfilmK15';

    /** K-17 */
    public const GRFILM_RATING_GRFILM_K17 = 'grfilmK17';

    /** K-18 */
    public const GRFILM_RATING_GRFILM_K18 = 'grfilmK18';

    /** A `grfilmRating` of `grfilmUnrated`. */
    public const GRFILM_RATING_GRFILM_UNRATED = 'grfilmUnrated';

    /** A `icaaRating` of `icaaUnspecified`. */
    public const ICAA_RATING_ICAA_UNSPECIFIED = 'icaaUnspecified';

    /** APTA */
    public const ICAA_RATING_ICAA_APTA = 'icaaApta';

    /** 7 */
    public const ICAA_RATING_ICAA7 = 'icaa7';

    /** 12 */
    public const ICAA_RATING_ICAA12 = 'icaa12';

    /** 13 */
    public const ICAA_RATING_ICAA13 = 'icaa13';

    /** 16 */
    public const ICAA_RATING_ICAA16 = 'icaa16';

    /** 18 */
    public const ICAA_RATING_ICAA18 = 'icaa18';

    /** X */
    public const ICAA_RATING_ICAA_X = 'icaaX';

    /** A `icaaRating` of `icaaUnrated`. */
    public const ICAA_RATING_ICAA_UNRATED = 'icaaUnrated';

    /** A `ifcoRating` of `ifcoUnspecified`. */
    public const IFCO_RATING_IFCO_UNSPECIFIED = 'ifcoUnspecified';

    /** G */
    public const IFCO_RATING_IFCO_G = 'ifcoG';

    /** PG */
    public const IFCO_RATING_IFCO_PG = 'ifcoPg';

    /** 12 */
    public const IFCO_RATING_IFCO12 = 'ifco12';

    /** 12A */
    public const IFCO_RATING_IFCO12A = 'ifco12a';

    /** 15 */
    public const IFCO_RATING_IFCO15 = 'ifco15';

    /** 15A */
    public const IFCO_RATING_IFCO15A = 'ifco15a';

    /** 16 */
    public const IFCO_RATING_IFCO16 = 'ifco16';

    /** 18 */
    public const IFCO_RATING_IFCO18 = 'ifco18';

    /** A `ifcoRating` of `ifcoUnrated`. */
    public const IFCO_RATING_IFCO_UNRATED = 'ifcoUnrated';

    /** A `ilfilmRating` of `ilfilmUnspecified`. */
    public const ILFILM_RATING_ILFILM_UNSPECIFIED = 'ilfilmUnspecified';

    /** AA */
    public const ILFILM_RATING_ILFILM_AA = 'ilfilmAa';

    /** 12 */
    public const ILFILM_RATING_ILFILM12 = 'ilfilm12';

    /** 14 */
    public const ILFILM_RATING_ILFILM14 = 'ilfilm14';

    /** 16 */
    public const ILFILM_RATING_ILFILM16 = 'ilfilm16';

    /** 18 */
    public const ILFILM_RATING_ILFILM18 = 'ilfilm18';

    /** A `ilfilmRating` of `ilfilmUnrated`. */
    public const ILFILM_RATING_ILFILM_UNRATED = 'ilfilmUnrated';

    /** A `incaaRating` of `incaaUnspecified`. */
    public const INCAA_RATING_INCAA_UNSPECIFIED = 'incaaUnspecified';

    /** ATP (Apta para todo publico) */
    public const INCAA_RATING_INCAA_ATP = 'incaaAtp';

    /** 13 (Solo apta para mayores de 13 años) */
    public const INCAA_RATING_INCAA_SAM13 = 'incaaSam13';

    /** 16 (Solo apta para mayores de 16 años) */
    public const INCAA_RATING_INCAA_SAM16 = 'incaaSam16';

    /** 18 (Solo apta para mayores de 18 años) */
    public const INCAA_RATING_INCAA_SAM18 = 'incaaSam18';

    /** X (Solo apta para mayores de 18 años, de exhibición condicionada) */
    public const INCAA_RATING_INCAA_C = 'incaaC';

    /** A `incaaRating` of `incaaUnrated`. */
    public const INCAA_RATING_INCAA_UNRATED = 'incaaUnrated';

    /** A `kfcbRating` of `kfcbUnspecified`. */
    public const KFCB_RATING_KFCB_UNSPECIFIED = 'kfcbUnspecified';

    /** GE */
    public const KFCB_RATING_KFCB_G = 'kfcbG';

    /** PG */
    public const KFCB_RATING_KFCB_PG = 'kfcbPg';

    /** 16 */
    public const KFCB_RATING_KFCB16PLUS = 'kfcb16plus';

    /** 18 */
    public const KFCB_RATING_KFCB_R = 'kfcbR';

    /** A `kfcbRating` of `kfcbUnrated`. */
    public const KFCB_RATING_KFCB_UNRATED = 'kfcbUnrated';

    /** A `kijkwijzerRating` of `kijkwijzerUnspecified`. */
    public const KIJKWIJZER_RATING_KIJKWIJZER_UNSPECIFIED = 'kijkwijzerUnspecified';

    /** AL */
    public const KIJKWIJZER_RATING_KIJKWIJZER_AL = 'kijkwijzerAl';

    /** 6 */
    public const KIJKWIJZER_RATING_KIJKWIJZER6 = 'kijkwijzer6';

    /** 9 */
    public const KIJKWIJZER_RATING_KIJKWIJZER9 = 'kijkwijzer9';

    /** 12 */
    public const KIJKWIJZER_RATING_KIJKWIJZER12 = 'kijkwijzer12';

    /** 16 */
    public const KIJKWIJZER_RATING_KIJKWIJZER16 = 'kijkwijzer16';

    /** A `kijkwijzerRating` of `kijkwijzer18`. */
    public const KIJKWIJZER_RATING_KIJKWIJZER18 = 'kijkwijzer18';

    /** A `kijkwijzerRating` of `kijkwijzerUnrated`. */
    public const KIJKWIJZER_RATING_KIJKWIJZER_UNRATED = 'kijkwijzerUnrated';

    /** A `kmrbRating` of `kmrbUnspecified`. */
    public const KMRB_RATING_KMRB_UNSPECIFIED = 'kmrbUnspecified';

    /** 전체관람가 */
    public const KMRB_RATING_KMRB_ALL = 'kmrbAll';

    /** 12세 이상 관람가 */
    public const KMRB_RATING_KMRB12PLUS = 'kmrb12plus';

    /** 15세 이상 관람가 */
    public const KMRB_RATING_KMRB15PLUS = 'kmrb15plus';

    /** A `kmrbRating` of `kmrbTeenr`. */
    public const KMRB_RATING_KMRB_TEENR = 'kmrbTeenr';

    /** 청소년 관람불가 */
    public const KMRB_RATING_KMRB_R = 'kmrbR';

    /** A `kmrbRating` of `kmrbUnrated`. */
    public const KMRB_RATING_KMRB_UNRATED = 'kmrbUnrated';

    /** A `lsfRating` of `lsfUnspecified`. */
    public const LSF_RATING_LSF_UNSPECIFIED = 'lsfUnspecified';

    /** SU */
    public const LSF_RATING_LSF_SU = 'lsfSu';

    /** A */
    public const LSF_RATING_LSF_A = 'lsfA';

    /**
     * BO
     *
     * @deprecated
     */
    public const LSF_RATING_LSF_BO = 'lsfBo';

    /** 13 */
    public const LSF_RATING_LSF13 = 'lsf13';

    /**
     * R
     *
     * @deprecated
     */
    public const LSF_RATING_LSF_R = 'lsfR';

    /** 17 */
    public const LSF_RATING_LSF17 = 'lsf17';

    /**
     * D
     *
     * @deprecated
     */
    public const LSF_RATING_LSF_D = 'lsfD';

    /** 21 */
    public const LSF_RATING_LSF21 = 'lsf21';

    /**
     * A `lsfRating` of `lsfUnrated`.
     *
     * @deprecated
     */
    public const LSF_RATING_LSF_UNRATED = 'lsfUnrated';

    /** A `mccaaRating` of `mccaaUnspecified`. */
    public const MCCAA_RATING_MCCAA_UNSPECIFIED = 'mccaaUnspecified';

    /** U */
    public const MCCAA_RATING_MCCAA_U = 'mccaaU';

    /** PG */
    public const MCCAA_RATING_MCCAA_PG = 'mccaaPg';

    /** 12A */
    public const MCCAA_RATING_MCCAA12A = 'mccaa12a';

    /** 12 */
    public const MCCAA_RATING_MCCAA12 = 'mccaa12';

    /** 14 - this rating was removed from the new classification structure introduced in 2013. */
    public const MCCAA_RATING_MCCAA14 = 'mccaa14';

    /** 15 */
    public const MCCAA_RATING_MCCAA15 = 'mccaa15';

    /** 16 - this rating was removed from the new classification structure introduced in 2013. */
    public const MCCAA_RATING_MCCAA16 = 'mccaa16';

    /** 18 */
    public const MCCAA_RATING_MCCAA18 = 'mccaa18';

    /** A `mccaaRating` of `mccaaUnrated`. */
    public const MCCAA_RATING_MCCAA_UNRATED = 'mccaaUnrated';

    /** A `mccypRating` of `mccypUnspecified`. */
    public const MCCYP_RATING_MCCYP_UNSPECIFIED = 'mccypUnspecified';

    /** A */
    public const MCCYP_RATING_MCCYP_A = 'mccypA';

    /** 7 */
    public const MCCYP_RATING_MCCYP7 = 'mccyp7';

    /** 11 */
    public const MCCYP_RATING_MCCYP11 = 'mccyp11';

    /** 15 */
    public const MCCYP_RATING_MCCYP15 = 'mccyp15';

    /** A `mccypRating` of `mccypUnrated`. */
    public const MCCYP_RATING_MCCYP_UNRATED = 'mccypUnrated';

    /** A `mcstRating` of `mcstUnspecified`. */
    public const MCST_RATING_MCST_UNSPECIFIED = 'mcstUnspecified';

    /** P */
    public const MCST_RATING_MCST_P = 'mcstP';

    /** 0 */
    public const MCST_RATING_MCST0 = 'mcst0';

    /** C13 */
    public const MCST_RATING_MCST_C13 = 'mcstC13';

    /** C16 */
    public const MCST_RATING_MCST_C16 = 'mcstC16';

    /** 16+ */
    public const MCST_RATING_MCST16PLUS = 'mcst16plus';

    /** C18 */
    public const MCST_RATING_MCST_C18 = 'mcstC18';

    /** MCST_G_PG */
    public const MCST_RATING_MCST_GPG = 'mcstGPg';

    /** A `mcstRating` of `mcstUnrated`. */
    public const MCST_RATING_MCST_UNRATED = 'mcstUnrated';

    /** A `mdaRating` of `mdaUnspecified`. */
    public const MDA_RATING_MDA_UNSPECIFIED = 'mdaUnspecified';

    /** G */
    public const MDA_RATING_MDA_G = 'mdaG';

    /** PG */
    public const MDA_RATING_MDA_PG = 'mdaPg';

    /** PG13 */
    public const MDA_RATING_MDA_PG13 = 'mdaPg13';

    /** NC16 */
    public const MDA_RATING_MDA_NC16 = 'mdaNc16';

    /** M18 */
    public const MDA_RATING_MDA_M18 = 'mdaM18';

    /** R21 */
    public const MDA_RATING_MDA_R21 = 'mdaR21';

    /** A `mdaRating` of `mdaUnrated`. */
    public const MDA_RATING_MDA_UNRATED = 'mdaUnrated';

    /** A `medietilsynetRating` of `medietilsynetUnspecified`. */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET_UNSPECIFIED = 'medietilsynetUnspecified';

    /** A */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET_A = 'medietilsynetA';

    /** 6 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET6 = 'medietilsynet6';

    /** 7 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET7 = 'medietilsynet7';

    /** 9 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET9 = 'medietilsynet9';

    /** 11 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET11 = 'medietilsynet11';

    /** 12 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET12 = 'medietilsynet12';

    /** 15 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET15 = 'medietilsynet15';

    /** 18 */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET18 = 'medietilsynet18';

    /** A `medietilsynetRating` of `medietilsynetUnrated`. */
    public const MEDIETILSYNET_RATING_MEDIETILSYNET_UNRATED = 'medietilsynetUnrated';

    /** A `mekuRating` of `mekuUnspecified`. */
    public const MEKU_RATING_MEKU_UNSPECIFIED = 'mekuUnspecified';

    /** S */
    public const MEKU_RATING_MEKU_S = 'mekuS';

    /** 7 */
    public const MEKU_RATING_MEKU7 = 'meku7';

    /** 12 */
    public const MEKU_RATING_MEKU12 = 'meku12';

    /** 16 */
    public const MEKU_RATING_MEKU16 = 'meku16';

    /** 18 */
    public const MEKU_RATING_MEKU18 = 'meku18';

    /** A `mekuRating` of `mekuUnrated`. */
    public const MEKU_RATING_MEKU_UNRATED = 'mekuUnrated';

    /** A `menaMpaaRating` of `menaMpaaUnspecified`. */
    public const MENA_MPAA_RATING_MENA_MPAA_UNSPECIFIED = 'menaMpaaUnspecified';

    /** G */
    public const MENA_MPAA_RATING_MENA_MPAA_G = 'menaMpaaG';

    /** PG */
    public const MENA_MPAA_RATING_MENA_MPAA_PG = 'menaMpaaPg';

    /** PG-13 */
    public const MENA_MPAA_RATING_MENA_MPAA_PG13 = 'menaMpaaPg13';

    /** R */
    public const MENA_MPAA_RATING_MENA_MPAA_R = 'menaMpaaR';

    /** To keep the same enum values as MPAA's items have, skip NC_17. */
    public const MENA_MPAA_RATING_MENA_MPAA_UNRATED = 'menaMpaaUnrated';

    /** A `mibacRating` of `mibacUnspecified`. */
    public const MIBAC_RATING_MIBAC_UNSPECIFIED = 'mibacUnspecified';

    /** A `mibacRating` of `mibacT`. */
    public const MIBAC_RATING_MIBAC_T = 'mibacT';

    /** A `mibacRating` of `mibacVap`. */
    public const MIBAC_RATING_MIBAC_VAP = 'mibacVap';

    /** A `mibacRating` of `mibacVm6`. */
    public const MIBAC_RATING_MIBAC_VM6 = 'mibacVm6';

    /** A `mibacRating` of `mibacVm12`. */
    public const MIBAC_RATING_MIBAC_VM12 = 'mibacVm12';

    /** A `mibacRating` of `mibacVm14`. */
    public const MIBAC_RATING_MIBAC_VM14 = 'mibacVm14';

    /** A `mibacRating` of `mibacVm16`. */
    public const MIBAC_RATING_MIBAC_VM16 = 'mibacVm16';

    /** A `mibacRating` of `mibacVm18`. */
    public const MIBAC_RATING_MIBAC_VM18 = 'mibacVm18';

    /** A `mibacRating` of `mibacUnrated`. */
    public const MIBAC_RATING_MIBAC_UNRATED = 'mibacUnrated';

    /** A `mocRating` of `mocUnspecified`. */
    public const MOC_RATING_MOC_UNSPECIFIED = 'mocUnspecified';

    /** E */
    public const MOC_RATING_MOC_E = 'mocE';

    /** T */
    public const MOC_RATING_MOC_T = 'mocT';

    /** 7 */
    public const MOC_RATING_MOC7 = 'moc7';

    /** 12 */
    public const MOC_RATING_MOC12 = 'moc12';

    /** 15 */
    public const MOC_RATING_MOC15 = 'moc15';

    /** 18 */
    public const MOC_RATING_MOC18 = 'moc18';

    /** X */
    public const MOC_RATING_MOC_X = 'mocX';

    /** Banned */
    public const MOC_RATING_MOC_BANNED = 'mocBanned';

    /** A `mocRating` of `mocUnrated`. */
    public const MOC_RATING_MOC_UNRATED = 'mocUnrated';

    /** A `moctwRating` of `moctwUnspecified`. */
    public const MOCTW_RATING_MOCTW_UNSPECIFIED = 'moctwUnspecified';

    /** G */
    public const MOCTW_RATING_MOCTW_G = 'moctwG';

    /** P */
    public const MOCTW_RATING_MOCTW_P = 'moctwP';

    /** PG */
    public const MOCTW_RATING_MOCTW_PG = 'moctwPg';

    /** R */
    public const MOCTW_RATING_MOCTW_R = 'moctwR';

    /** A `moctwRating` of `moctwUnrated`. */
    public const MOCTW_RATING_MOCTW_UNRATED = 'moctwUnrated';

    /** R-12 */
    public const MOCTW_RATING_MOCTW_R12 = 'moctwR12';

    /** R-15 */
    public const MOCTW_RATING_MOCTW_R15 = 'moctwR15';

    /** A `mpaaRating` of `mpaaUnspecified`. */
    public const MPAA_RATING_MPAA_UNSPECIFIED = 'mpaaUnspecified';

    /** G */
    public const MPAA_RATING_MPAA_G = 'mpaaG';

    /** PG */
    public const MPAA_RATING_MPAA_PG = 'mpaaPg';

    /** PG-13 */
    public const MPAA_RATING_MPAA_PG13 = 'mpaaPg13';

    /** R */
    public const MPAA_RATING_MPAA_R = 'mpaaR';

    /** NC-17 */
    public const MPAA_RATING_MPAA_NC17 = 'mpaaNc17';

    /** ! X */
    public const MPAA_RATING_MPAA_X = 'mpaaX';

    /** A `mpaaRating` of `mpaaUnrated`. */
    public const MPAA_RATING_MPAA_UNRATED = 'mpaaUnrated';

    /** A `mpaatRating` of `mpaatUnspecified`. */
    public const MPAAT_RATING_MPAAT_UNSPECIFIED = 'mpaatUnspecified';

    /** GB */
    public const MPAAT_RATING_MPAAT_GB = 'mpaatGb';

    /** RB */
    public const MPAAT_RATING_MPAAT_RB = 'mpaatRb';

    /** A `mtrcbRating` of `mtrcbUnspecified`. */
    public const MTRCB_RATING_MTRCB_UNSPECIFIED = 'mtrcbUnspecified';

    /** G */
    public const MTRCB_RATING_MTRCB_G = 'mtrcbG';

    /** PG */
    public const MTRCB_RATING_MTRCB_PG = 'mtrcbPg';

    /** R-13 */
    public const MTRCB_RATING_MTRCB_R13 = 'mtrcbR13';

    /** R-16 */
    public const MTRCB_RATING_MTRCB_R16 = 'mtrcbR16';

    /** R-18 */
    public const MTRCB_RATING_MTRCB_R18 = 'mtrcbR18';

    /** X */
    public const MTRCB_RATING_MTRCB_X = 'mtrcbX';

    /** A `mtrcbRating` of `mtrcbUnrated`. */
    public const MTRCB_RATING_MTRCB_UNRATED = 'mtrcbUnrated';

    /** A `nbcRating` of `nbcUnspecified`. */
    public const NBC_RATING_NBC_UNSPECIFIED = 'nbcUnspecified';

    /** G */
    public const NBC_RATING_NBC_G = 'nbcG';

    /** PG */
    public const NBC_RATING_NBC_PG = 'nbcPg';

    /** 12+ */
    public const NBC_RATING_NBC12PLUS = 'nbc12plus';

    /** 15+ */
    public const NBC_RATING_NBC15PLUS = 'nbc15plus';

    /** 18+ */
    public const NBC_RATING_NBC18PLUS = 'nbc18plus';

    /** 18+R */
    public const NBC_RATING_NBC18PLUSR = 'nbc18plusr';

    /** PU */
    public const NBC_RATING_NBC_PU = 'nbcPu';

    /** A `nbcRating` of `nbcUnrated`. */
    public const NBC_RATING_NBC_UNRATED = 'nbcUnrated';

    /** A `nbcplRating` of `nbcplUnspecified`. */
    public const NBCPL_RATING_NBCPL_UNSPECIFIED = 'nbcplUnspecified';

    /** A `nbcplRating` of `nbcplI`. */
    public const NBCPL_RATING_NBCPL_I = 'nbcplI';

    /** A `nbcplRating` of `nbcplIi`. */
    public const NBCPL_RATING_NBCPL_II = 'nbcplIi';

    /** A `nbcplRating` of `nbcplIii`. */
    public const NBCPL_RATING_NBCPL_III = 'nbcplIii';

    /** A `nbcplRating` of `nbcplIv`. */
    public const NBCPL_RATING_NBCPL_IV = 'nbcplIv';

    /** A `nbcplRating` of `nbcpl18plus`. */
    public const NBCPL_RATING_NBCPL18PLUS = 'nbcpl18plus';

    /** A `nbcplRating` of `nbcplUnrated`. */
    public const NBCPL_RATING_NBCPL_UNRATED = 'nbcplUnrated';

    /** A `nfrcRating` of `nfrcUnspecified`. */
    public const NFRC_RATING_NFRC_UNSPECIFIED = 'nfrcUnspecified';

    /** A */
    public const NFRC_RATING_NFRC_A = 'nfrcA';

    /** B */
    public const NFRC_RATING_NFRC_B = 'nfrcB';

    /** C */
    public const NFRC_RATING_NFRC_C = 'nfrcC';

    /** D */
    public const NFRC_RATING_NFRC_D = 'nfrcD';

    /** X */
    public const NFRC_RATING_NFRC_X = 'nfrcX';

    /** A `nfrcRating` of `nfrcUnrated`. */
    public const NFRC_RATING_NFRC_UNRATED = 'nfrcUnrated';

    /** A `nfvcbRating` of `nfvcbUnspecified`. */
    public const NFVCB_RATING_NFVCB_UNSPECIFIED = 'nfvcbUnspecified';

    /** G */
    public const NFVCB_RATING_NFVCB_G = 'nfvcbG';

    /** PG */
    public const NFVCB_RATING_NFVCB_PG = 'nfvcbPg';

    /** 12 */
    public const NFVCB_RATING_NFVCB12 = 'nfvcb12';

    /** 12A */
    public const NFVCB_RATING_NFVCB12A = 'nfvcb12a';

    /** 15 */
    public const NFVCB_RATING_NFVCB15 = 'nfvcb15';

    /** 18 */
    public const NFVCB_RATING_NFVCB18 = 'nfvcb18';

    /** RE */
    public const NFVCB_RATING_NFVCB_RE = 'nfvcbRe';

    /** A `nfvcbRating` of `nfvcbUnrated`. */
    public const NFVCB_RATING_NFVCB_UNRATED = 'nfvcbUnrated';

    /** A `nkclvRating` of `nkclvUnspecified`. */
    public const NKCLV_RATING_NKCLV_UNSPECIFIED = 'nkclvUnspecified';

    /** U */
    public const NKCLV_RATING_NKCLV_U = 'nkclvU';

    /** 7+ */
    public const NKCLV_RATING_NKCLV7PLUS = 'nkclv7plus';

    /** 12+ */
    public const NKCLV_RATING_NKCLV12PLUS = 'nkclv12plus';

    /** ! 16+ */
    public const NKCLV_RATING_NKCLV16PLUS = 'nkclv16plus';

    /** 18+ */
    public const NKCLV_RATING_NKCLV18PLUS = 'nkclv18plus';

    /** A `nkclvRating` of `nkclvUnrated`. */
    public const NKCLV_RATING_NKCLV_UNRATED = 'nkclvUnrated';

    /** A `nmcRating` of `nmcUnspecified`. */
    public const NMC_RATING_NMC_UNSPECIFIED = 'nmcUnspecified';

    /** G */
    public const NMC_RATING_NMC_G = 'nmcG';

    /** PG */
    public const NMC_RATING_NMC_PG = 'nmcPg';

    /** PG-13 */
    public const NMC_RATING_NMC_PG13 = 'nmcPg13';

    /** PG-15 */
    public const NMC_RATING_NMC_PG15 = 'nmcPg15';

    /** 15+ */
    public const NMC_RATING_NMC15PLUS = 'nmc15plus';

    /** 18+ */
    public const NMC_RATING_NMC18PLUS = 'nmc18plus';

    /** 18TC */
    public const NMC_RATING_NMC18TC = 'nmc18tc';

    /** A `nmcRating` of `nmcUnrated`. */
    public const NMC_RATING_NMC_UNRATED = 'nmcUnrated';

    /** A `oflcRating` of `oflcUnspecified`. */
    public const OFLC_RATING_OFLC_UNSPECIFIED = 'oflcUnspecified';

    /** G */
    public const OFLC_RATING_OFLC_G = 'oflcG';

    /** PG */
    public const OFLC_RATING_OFLC_PG = 'oflcPg';

    /** M */
    public const OFLC_RATING_OFLC_M = 'oflcM';

    /** R13 */
    public const OFLC_RATING_OFLC_R13 = 'oflcR13';

    /** R15 */
    public const OFLC_RATING_OFLC_R15 = 'oflcR15';

    /** R16 */
    public const OFLC_RATING_OFLC_R16 = 'oflcR16';

    /** R18 */
    public const OFLC_RATING_OFLC_R18 = 'oflcR18';

    /** A `oflcRating` of `oflcUnrated`. */
    public const OFLC_RATING_OFLC_UNRATED = 'oflcUnrated';

    /** RP13 */
    public const OFLC_RATING_OFLC_RP13 = 'oflcRp13';

    /** RP16 */
    public const OFLC_RATING_OFLC_RP16 = 'oflcRp16';

    /** RP18 */
    public const OFLC_RATING_OFLC_RP18 = 'oflcRp18';

    /** A `pefilmRating` of `pefilmUnspecified`. */
    public const PEFILM_RATING_PEFILM_UNSPECIFIED = 'pefilmUnspecified';

    /** PT */
    public const PEFILM_RATING_PEFILM_PT = 'pefilmPt';

    /** PG */
    public const PEFILM_RATING_PEFILM_PG = 'pefilmPg';

    /** 14 */
    public const PEFILM_RATING_PEFILM14 = 'pefilm14';

    /** 18 */
    public const PEFILM_RATING_PEFILM18 = 'pefilm18';

    /** A `pefilmRating` of `pefilmUnrated`. */
    public const PEFILM_RATING_PEFILM_UNRATED = 'pefilmUnrated';

    /** A `rcnofRating` of `rcnofUnspecified`. */
    public const RCNOF_RATING_RCNOF_UNSPECIFIED = 'rcnofUnspecified';

    /** A `rcnofRating` of `rcnofI`. */
    public const RCNOF_RATING_RCNOF_I = 'rcnofI';

    /** A `rcnofRating` of `rcnofIi`. */
    public const RCNOF_RATING_RCNOF_II = 'rcnofIi';

    /** A `rcnofRating` of `rcnofIii`. */
    public const RCNOF_RATING_RCNOF_III = 'rcnofIii';

    /** A `rcnofRating` of `rcnofIv`. */
    public const RCNOF_RATING_RCNOF_IV = 'rcnofIv';

    /** A `rcnofRating` of `rcnofV`. */
    public const RCNOF_RATING_RCNOF_V = 'rcnofV';

    /** A `rcnofRating` of `rcnofVi`. */
    public const RCNOF_RATING_RCNOF_VI = 'rcnofVi';

    /** A `rcnofRating` of `rcnofUnrated`. */
    public const RCNOF_RATING_RCNOF_UNRATED = 'rcnofUnrated';

    /** A `resorteviolenciaRating` of `resorteviolenciaUnspecified`. */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_UNSPECIFIED = 'resorteviolenciaUnspecified';

    /** A */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_A = 'resorteviolenciaA';

    /** B */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_B = 'resorteviolenciaB';

    /** C */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_C = 'resorteviolenciaC';

    /** D */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_D = 'resorteviolenciaD';

    /** E */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_E = 'resorteviolenciaE';

    /** A `resorteviolenciaRating` of `resorteviolenciaUnrated`. */
    public const RESORTEVIOLENCIA_RATING_RESORTEVIOLENCIA_UNRATED = 'resorteviolenciaUnrated';

    /** A `rtcRating` of `rtcUnspecified`. */
    public const RTC_RATING_RTC_UNSPECIFIED = 'rtcUnspecified';

    /** AA */
    public const RTC_RATING_RTC_AA = 'rtcAa';

    /** A */
    public const RTC_RATING_RTC_A = 'rtcA';

    /** B */
    public const RTC_RATING_RTC_B = 'rtcB';

    /** B15 */
    public const RTC_RATING_RTC_B15 = 'rtcB15';

    /** C */
    public const RTC_RATING_RTC_C = 'rtcC';

    /** D */
    public const RTC_RATING_RTC_D = 'rtcD';

    /** A `rtcRating` of `rtcUnrated`. */
    public const RTC_RATING_RTC_UNRATED = 'rtcUnrated';

    /** A `rteRating` of `rteUnspecified`. */
    public const RTE_RATING_RTE_UNSPECIFIED = 'rteUnspecified';

    /** GA */
    public const RTE_RATING_RTE_GA = 'rteGa';

    /** CH */
    public const RTE_RATING_RTE_CH = 'rteCh';

    /** PS */
    public const RTE_RATING_RTE_PS = 'rtePs';

    /** MA */
    public const RTE_RATING_RTE_MA = 'rteMa';

    /** A `rteRating` of `rteUnrated`. */
    public const RTE_RATING_RTE_UNRATED = 'rteUnrated';

    /** A `russiaRating` of `russiaUnspecified`. */
    public const RUSSIA_RATING_RUSSIA_UNSPECIFIED = 'russiaUnspecified';

    /** 0+ */
    public const RUSSIA_RATING_RUSSIA0 = 'russia0';

    /** 6+ */
    public const RUSSIA_RATING_RUSSIA6 = 'russia6';

    /** 12+ */
    public const RUSSIA_RATING_RUSSIA12 = 'russia12';

    /** 16+ */
    public const RUSSIA_RATING_RUSSIA16 = 'russia16';

    /** 18+ */
    public const RUSSIA_RATING_RUSSIA18 = 'russia18';

    /** A `russiaRating` of `russiaUnrated`. */
    public const RUSSIA_RATING_RUSSIA_UNRATED = 'russiaUnrated';

    /** A `skfilmRating` of `skfilmUnspecified`. */
    public const SKFILM_RATING_SKFILM_UNSPECIFIED = 'skfilmUnspecified';

    /** G */
    public const SKFILM_RATING_SKFILM_G = 'skfilmG';

    /** P2 */
    public const SKFILM_RATING_SKFILM_P2 = 'skfilmP2';

    /** P5 */
    public const SKFILM_RATING_SKFILM_P5 = 'skfilmP5';

    /** P8 */
    public const SKFILM_RATING_SKFILM_P8 = 'skfilmP8';

    /** A `skfilmRating` of `skfilmUnrated`. */
    public const SKFILM_RATING_SKFILM_UNRATED = 'skfilmUnrated';

    /** A `smaisRating` of `smaisUnspecified`. */
    public const SMAIS_RATING_SMAIS_UNSPECIFIED = 'smaisUnspecified';

    /** L */
    public const SMAIS_RATING_SMAIS_L = 'smaisL';

    /** 7 */
    public const SMAIS_RATING_SMAIS7 = 'smais7';

    /** 12 */
    public const SMAIS_RATING_SMAIS12 = 'smais12';

    /** 14 */
    public const SMAIS_RATING_SMAIS14 = 'smais14';

    /** 16 */
    public const SMAIS_RATING_SMAIS16 = 'smais16';

    /** 18 */
    public const SMAIS_RATING_SMAIS18 = 'smais18';

    /** A `smaisRating` of `smaisUnrated`. */
    public const SMAIS_RATING_SMAIS_UNRATED = 'smaisUnrated';

    /** A `smsaRating` of `smsaUnspecified`. */
    public const SMSA_RATING_SMSA_UNSPECIFIED = 'smsaUnspecified';

    /** All ages */
    public const SMSA_RATING_SMSA_A = 'smsaA';

    /** 7 */
    public const SMSA_RATING_SMSA7 = 'smsa7';

    /** 11 */
    public const SMSA_RATING_SMSA11 = 'smsa11';

    /** 15 */
    public const SMSA_RATING_SMSA15 = 'smsa15';

    /** A `smsaRating` of `smsaUnrated`. */
    public const SMSA_RATING_SMSA_UNRATED = 'smsaUnrated';

    /** A `tvpgRating` of `tvpgUnspecified`. */
    public const TVPG_RATING_TVPG_UNSPECIFIED = 'tvpgUnspecified';

    /** TV-Y */
    public const TVPG_RATING_TVPG_Y = 'tvpgY';

    /** TV-Y7 */
    public const TVPG_RATING_TVPG_Y7 = 'tvpgY7';

    /** TV-Y7-FV */
    public const TVPG_RATING_TVPG_Y7_FV = 'tvpgY7Fv';

    /** TV-G */
    public const TVPG_RATING_TVPG_G = 'tvpgG';

    /** TV-PG */
    public const TVPG_RATING_TVPG_PG = 'tvpgPg';

    /** TV-14 */
    public const TVPG_RATING_PG14 = 'pg14';

    /** TV-MA */
    public const TVPG_RATING_TVPG_MA = 'tvpgMa';

    /** A `tvpgRating` of `tvpgUnrated`. */
    public const TVPG_RATING_TVPG_UNRATED = 'tvpgUnrated';

    /** A `ytRating` of `ytUnspecified`. */
    public const YT_RATING_YT_UNSPECIFIED = 'ytUnspecified';

    /** A `ytRating` of `ytAgeRestricted`. */
    public const YT_RATING_YT_AGE_RESTRICTED = 'ytAgeRestricted';
}
