-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: May 10, 2024 at 06:45 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `app_sustainability`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin_users`
--

CREATE TABLE `admin_users` (
  `id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `admin_users`
--

INSERT INTO `admin_users` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admingc');

-- --------------------------------------------------------

--
-- Table structure for table `certificates`
--

CREATE TABLE `certificates` (
  `certificate_id` int(10) UNSIGNED NOT NULL,
  `type` enum('Golden','Silver','Bronze') NOT NULL,
  `description` text NOT NULL,
  `img` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificates`
--

INSERT INTO `certificates` (`certificate_id`, `type`, `description`, `img`) VALUES
(1, 'Golden', 'Our Golden Certificate celebrates companies that have demonstrated exceptional commitment to sustainability. It symbolizes unwavering dedication to environmental stewardship and the pursuit of green initiatives.', '../img/certificates/1.jpg'),
(2, 'Silver', 'The Silver Certificate recognizes companies making strides towards sustainability excellence. It acknowledges remarkable achievement in environmental stewardship and the pursuit of sustainability goals.', '../img/certificates/2.jpg'),
(3, 'Bronze', 'The Bronze Certificate signifies dedication to sustainability and progress in greener practices. It reflects a commitment to environmental responsibility and the journey towards embracing sustainable principles.', '../img/certificates/3.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `certificate_templates`
--

CREATE TABLE `certificate_templates` (
  `template_id` int(10) UNSIGNED NOT NULL,
  `template_name` varchar(255) NOT NULL,
  `header_text` text DEFAULT NULL,
  `body_text` text DEFAULT NULL,
  `img` varchar(255) DEFAULT NULL,
  `footer_text` text DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `certificate_templates`
--

INSERT INTO `certificate_templates` (`template_id`, `template_name`, `header_text`, `body_text`, `img`, `footer_text`, `created_at`) VALUES
(1, 'golden', 'Golden Certificate', 'This is to certify that [CompanyName] has achieved outstanding results in sustainability measures on [Date].\r\nShowing green ground cover interspersed with leaves, this distinguished certificate signifies the highest level \r\nof sustainability achievement. It symbolizes the unwavering commitment of the company to environmental \r\nstewardship and the exceptional fulfilment of sustainability targets. Reflecting dedication that surpasses \r\nconventional norms, it stands as a testament to their exemplary leadership in fostering a greener future.', '../img/certificates/1.jpg', 'Congratulations on your commitment to sustainability.', '2024-05-02 12:14:40'),
(2, 'silver', 'Silver Certificate', 'This is to certify that [CompanyName] has achieved \r\noutstanding results in sustainability measures on [Date]. Showcases a captivating image of lush foliage, \r\nemblematic of remarkable sustainability achievement akin to a thriving ecosystem. It acknowledges exceptional \r\nenvironmental stewardship and the outstanding attainment of sustainability targets, reflecting a commitment \r\nindicative of a company advancing steadily along the path towards sustainability excellence.', '../img/certificates/2.jpg', 'Congratulations on your commitment to sustainability.', '2024-05-02 12:14:40'),
(3, 'bronze', 'Bronze Certificate', 'This is to certify that [CompanyName] has achieved outstanding results in sustainability measures on [Date].This distinguished certificate showcases a captivating \r\nFeaturing an image of a single leaf resting in water, this certificate embodies dedication to sustainability, \r\nsymbolizing steps towards greener practices. Like the leaf adrift, it evokes both achievement and growth, \r\nmirroring the cycle of renewal. Reflecting a resolve to embrace sustainable principles, it stands as a beacon, \r\nmarking progress in sustainability initiatives.', '../img/certificates/3.jpg', 'Congratulations on your commitment to sustainability.', '2024-05-02 12:14:40');

-- --------------------------------------------------------

--
-- Table structure for table `companies`
--

CREATE TABLE `companies` (
  `company_id` int(10) UNSIGNED NOT NULL,
  `company_name` varchar(100) NOT NULL,
  `industry` varchar(50) NOT NULL,
  `telephone_number` varchar(20) NOT NULL,
  `contact_person` varchar(100) NOT NULL,
  `status` enum('active','inactive','deactivated') NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies`
--

INSERT INTO `companies` (`company_id`, `company_name`, `industry`, `telephone_number`, `contact_person`, `status`, `user_id`) VALUES
(1, 'Sustainable Transport Ltd', 'Transportation', '07927486117', 'Anna Lopez', 'active', 2),
(3, 'Danna\'s and friends Cafe', 'Hospitality', '07927486117', 'Danna Sequeiros Huillca', 'active', 1),
(4, 'Cars Ltd', 'Transportation', '07777777777', 'Joe Doe', 'active', 3),
(5, 'Musical Ltd', 'Music and Friends', '7555555555', 'Gian Palau', 'active', 5),
(6, 'Singer Ltd', 'Music', '07666666666', 'Luis Fonsi', 'active', 6),
(7, 'Houses Ltd', 'Construction', '07777777777', 'Ana Sans', 'active', 7);

-- --------------------------------------------------------

--
-- Table structure for table `companies_certificates`
--

CREATE TABLE `companies_certificates` (
  `certificate_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `certificate_type` enum('gold','silver','bronze') DEFAULT NULL,
  `achievement_id` int(10) UNSIGNED DEFAULT NULL,
  `certificate_data` blob DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `companies_certificates`
--

INSERT INTO `companies_certificates` (`certificate_id`, `company_id`, `certificate_type`, `achievement_id`, `certificate_data`) VALUES
(3, 3, 'gold', NULL, NULL),
(4, 3, 'gold', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `company_achievements`
--

CREATE TABLE `company_achievements` (
  `achievement_id` int(10) UNSIGNED NOT NULL,
  `company_id` int(10) UNSIGNED NOT NULL,
  `achievement_type` varchar(255) NOT NULL CHECK (`achievement_type` in ('measure','voucher')),
  `measure_id` int(10) UNSIGNED DEFAULT NULL,
  `voucher_id` int(10) UNSIGNED DEFAULT NULL,
  `achievement_description` varchar(300) DEFAULT NULL,
  `points_earned` bigint(20) UNSIGNED NOT NULL,
  `date_achieved` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `company_achievements`
--

INSERT INTO `company_achievements` (`achievement_id`, `company_id`, `achievement_type`, `measure_id`, `voucher_id`, `achievement_description`, `points_earned`, `date_achieved`) VALUES
(54, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 01:43:14'),
(57, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 01:49:25'),
(58, 3, 'measure', 3, NULL, 'Eco-friendly Products/Services', 5, '2024-05-07 01:49:52'),
(59, 3, 'measure', 2, NULL, 'Energy-Efficient Infrastructure', 15, '2024-05-07 01:56:24'),
(60, 3, 'measure', 1, NULL, 'Waste Reduction', 10, '2024-05-07 02:10:00'),
(61, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:12:32'),
(62, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:15:48'),
(65, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:21:49'),
(66, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:22:22'),
(67, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:22:40'),
(68, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:24:53'),
(69, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:29:56'),
(70, 3, 'measure', 1, NULL, 'Waste Reduction', 5, '2024-05-07 02:34:45'),
(72, 3, 'voucher', NULL, 1, 'Tree Planting', 10, '2024-05-07 03:01:59'),
(73, 3, 'measure', 2, NULL, 'Energy-Efficient Infrastructure', 5, '2024-05-07 21:53:23'),
(74, 3, 'voucher', NULL, 2, 'Renewable Energy Credits', 10, '2024-05-08 20:51:31'),
(75, 3, 'voucher', NULL, 3, 'Wildlife Conservation', 20, '2024-05-08 20:51:31'),
(76, 3, 'voucher', NULL, 1, 'Tree Planting', 20, '2024-05-08 20:51:31'),
(77, 3, 'voucher', NULL, 5, 'Waste Reduction', 10, '2024-05-08 20:51:31'),
(78, 3, 'voucher', NULL, 4, 'Water Conservation', 10, '2024-05-08 20:51:31');

-- --------------------------------------------------------

--
-- Table structure for table `contact_us`
--

CREATE TABLE `contact_us` (
  `inquiry_id` int(10) UNSIGNED NOT NULL,
  `user_id` int(10) UNSIGNED NOT NULL,
  `subject` varchar(100) NOT NULL,
  `message` text NOT NULL,
  `date_received` datetime NOT NULL,
  `status` enum('pending','answered','closed') NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `green_vouchers`
--

CREATE TABLE `green_vouchers` (
  `voucher_id` int(10) UNSIGNED NOT NULL,
  `voucher_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `impact` text NOT NULL,
  `price` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `green_vouchers`
--

INSERT INTO `green_vouchers` (`voucher_id`, `voucher_type`, `description`, `impact`, `price`) VALUES
(1, 'Tree Planting', 'Each Tree Planting Voucher contributes directly to global reforestation efforts. The funds will be used to plant native\r\n species trees in both urban and rural areas, contributing to carbon sequestration, enhancing local biodiversity, and restoring natural \r\n habitats.', 'Improves air quality, enhances soil stability, increases biodiversity.', 10.00),
(2, 'Renewable Energy Credits', 'Purchasing Renewable Energy Credits helps finance the development and maintenance of clean energy projects, \r\nincluding wind, solar, and hydroelectric power facilities. This initiative aims to offset traditional electricity consumption with \r\nsustainable alternatives.', 'Reduces dependence on fossil fuels, lowers greenhouse gas emissions, promotes energy security.', 10.00),
(3, 'Wildlife Conservation', 'Funds from these vouchers support critical on-ground conservation efforts to protect endangered species and \r\ntheir natural habitats. Activities funded include anti-poaching patrols, wildlife health monitoring, and habitat restoration projects.', 'Preserves endangered species populations, maintains ecosystem functions, promotes biodiversity.', 10.00),
(4, 'Water Conservation', 'This voucher supports water-saving technologies in communities and industries, including modern irrigation \r\nsystems, water-efficient appliances, and educational programs on water conservation.', 'Enhances water efficiency, promotes sustainable \r\nwater use, helps manage water resources sustainably.', 10.00),
(5, 'Waste Reduction', 'Waste Reduction Initiatives focus on reducing landfill waste by enhancing recycling programs and composting \r\nfacilities. This includes purchasing recycling bins, supporting community composting programs, and educating the public about \r\nsustainable waste disposal practices.', 'Reduces landfill use, lowers environmental contaminants, encourages a circular economy.', 10.00),
(6, 'Eco-Education', 'These vouchers fund educational workshops and sustainability training programs in schools and communities. \r\nThe goal is to educate young people and adults about environmental issues and sustainable living practices.', 'Raises environmental \r\nawareness, empowers informed decision-making, fosters environmental responsibility.', 10.00),
(7, 'Coral Reef Restoration', 'Contributions go towards coral cultivation and planting efforts, which help restore damaged reefs. \r\nThis includes growing coral in nurseries and transplanting them to degraded areas.', 'Increases marine biodiversity, supports fisheries, \r\nprotects coastal regions.', 10.00);

-- --------------------------------------------------------

--
-- Table structure for table `partners`
--

CREATE TABLE `partners` (
  `partner_id` int(10) UNSIGNED NOT NULL,
  `name` varchar(255) NOT NULL,
  `img` varchar(255) DEFAULT NULL,
  `url` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `partners`
--

INSERT INTO `partners` (`partner_id`, `name`, `img`, `url`) VALUES
(1, 'Edinburgh College', '../img/partners/college.png', 'https://www.edinburghcollege.ac.uk/about-us/corporate-and-governance/sustainability'),
(2, 'The city of Edinburgh Council', '../img/partners/council.png', 'https://www.edinburgh.gov.uk/council-commitments/delivering-sustainable-future'),
(3, 'The Scottish Government', '../img/partners/government.png', 'https://www.gov.scot/policies/sustainable-performance/corporate-environmental-management/'),
(4, 'The Scottish Wildlife Trust', '../img/partners/wildlife.png', 'https://scottishwildlifetrust.org.uk/strategy2030/'),
(5, 'UNESCO', '../img/partners/unesco.png', 'https://www.unesco.org/en/environmental-commitment-and-policy');

-- --------------------------------------------------------

--
-- Table structure for table `site_content`
--

CREATE TABLE `site_content` (
  `content_id` int(10) UNSIGNED NOT NULL,
  `type` enum('promo_message','login_message','vision_message','home_image','contact_us_img','sustainability_intro','video','podcast','article') NOT NULL,
  `heading` varchar(255) DEFAULT NULL,
  `text_content` text DEFAULT NULL,
  `image_url` text DEFAULT NULL,
  `video_url` text DEFAULT NULL,
  `podcast_url` text DEFAULT NULL,
  `alt_text` varchar(255) DEFAULT NULL,
  `meta_description` text DEFAULT NULL,
  `meta_keywords` text DEFAULT NULL,
  `active` tinyint(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `site_content`
--

INSERT INTO `site_content` (`content_id`, `type`, `heading`, `text_content`, `image_url`, `video_url`, `podcast_url`, `alt_text`, `meta_description`, `meta_keywords`, `active`) VALUES
(1, 'promo_message', NULL, 'New to GreenCalculator? Unlock the full potential of our app by signing up for just \r\n£99 a year! Gain access to exclusive features, personalized insights, and a supportive community dedicated to \r\nsustainability. Take the first step towards earning accreditation and certificates for your business today.', 'img/promo.jpg', NULL, NULL, 'Promotional image', NULL, NULL, 1),
(2, 'login_message', 'Member Login', 'Already a Member? Welcome back! Sign in to your account to continue your \r\nsustainability journey with us.', NULL, NULL, NULL, 'Login message', NULL, NULL, 1),
(3, 'vision_message', 'Our Vision', 'We envision a world where every business makes sustainable choices, leaving \r\na positive impact on the environment. Our goal is to empower customers to measure, manage and promote their \r\nsustainability efforts through our innovative Green Calculator Application by providing a user-friendly \r\nplatform that quantifies and rewards green activities. We aim to inspire a culture of corporate responsibility \r\nand environmental stewardship. Together, we can create a greener more sustainable future for generations to \r\ncome.', NULL, NULL, NULL, 'vision message', NULL, NULL, 1),
(4, 'home_image', NULL, NULL, '../img/green.jpeg', NULL, NULL, 'Trees between buildings', NULL, NULL, 1),
(5, 'contact_us_img', NULL, NULL, '../img/more/contact_us.jpg', NULL, NULL, 'Sheep baaing', NULL, NULL, 1),
(6, 'sustainability_intro', 'Our Commitment to Sustainability', 'At [Your Company Name], sustainability is at \r\nthe core of everything we do. We are committed to reducing our environmental footprint and enhancing \r\neco-friendliness across all our operations. Join us as we explore the various initiatives and achievements \r\nthat help us stay true to our mission of fostering a sustainable future.', NULL, NULL, NULL, 'Intro message for sustainabililty page', NULL, NULL, 1),
(7, 'video', 'One Earth', 'Environmental short film created and edited to help raise awareness about our \r\nimpact on our environment.', NULL, 'QQYgCxu988s', NULL, 'Video about sustainability', NULL, NULL, 1),
(8, 'podcast', 'Climate Changers', 'Features interviews from leaders in the battle against climate change, \r\nfrom entrepreneurs to activists and educators. Lately, the podcast has focused primarily on regenerative \r\nagriculture, carbon farming, reforestation, and sustainable food, but earlier episodes focus more broadly on \r\nclimate issues such as clean energy, carbon capture, and the Paris Agreement.', NULL, '0ljm9zYslDePEqYDdCRobH', NULL, 'Podcast about energy as a service', NULL, NULL, 1),
(9, 'podcast', 'The Big Switch', 'Excellent introduction to how our energy system is being rebuilt to address \r\nclimate change. We need to transform buildings, homes, cars, and economy quickly and fairly to a net zero \r\nenergy system.', NULL, '2Ev0TdagUDFHsyCXHg2SD7', NULL, 'Podcast about the battery recycling dilema', NULL, NULL, 1),
(10, 'article', 'Guardian Sustainable Business', 'Known for its comprehensive coverage on global environmental \r\nissues, The Guardian also offers a section dedicated to sustainable business practices.', NULL, NULL, 'https://www.theguardian.com/sustainable-business', 'Recommended article about sustainable businesses', NULL, NULL, 1),
(11, 'article', 'GreenBiz Insights', 'This site provides news, insights, and best practices on how businesses \r\ncan achieve sustainability and drive profitability.', NULL, NULL, 'https://www.greenbiz.com/', 'Recommended article about business green practices', NULL, NULL, 1);

-- --------------------------------------------------------

--
-- Table structure for table `sustainability_activities`
--

CREATE TABLE `sustainability_activities` (
  `activity_id` int(10) UNSIGNED NOT NULL,
  `measure_id` int(10) UNSIGNED NOT NULL,
  `activity_description` text NOT NULL,
  `target_metric` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sustainability_activities`
--

INSERT INTO `sustainability_activities` (`activity_id`, `measure_id`, `activity_description`, `target_metric`) VALUES
(1, 1, 'Implement paperless office initiatives aimed at reducing paper usage across all departments. The goal is to decrease paper consumption by 20%, promoting digital alternatives and reducing environmental impact.', 'percentage reduction'),
(2, 1, 'Introduce waste segregation programs that enhance recycling processes within the company. Target a 15% increase in recycling rates by providing proper disposal bins and training for staff.', 'percentage increase'),
(3, 1, 'Reduce food waste through improved portion control and composting at company facilities. Aim to cut food waste generation by 10% by reviewing and adjusting food preparation and serving practices.', 'percentage reduction'),
(4, 2, 'Conduct comprehensive energy audits to identify low-cost opportunities for reducing energy consumption. Target a 15% reduction in energy use by implementing recommended changes within 12 months.', 'percentage reduction'),
(5, 2, 'Upgrade lighting across all company facilities to LED bulbs and install programmable thermostats for better energy management. This upgrade aims to achieve a 10% reduction in energy usage.', 'percentage reduction'),
(6, 2, 'Encourage employee engagement in energy-saving behaviors such as turning off lights and equipment when not in use. Set a goal to decrease energy usage by 5% through awareness campaigns and incentives.', 'percentage reduction'),
(7, 3, 'Introduce a product/service redesign initiative to minimize material usage and waste generation. Aim for a 5% reduction in the environmental footprint of products/services within the next year.', 'percentage reduction'),
(8, 3, 'Source eco-friendly materials and ingredients for all products and services, increasing the percentage of sustainable sourcing by 10%. This includes prioritizing suppliers who adhere to environmental standards.', 'percentage increase'),
(9, 3, 'Offer incentives for customers to return packaging for reuse or recycling, aiming to increase packaging recovery rates by 10%. This includes discounts on future purchases or rewards programs.', 'percentage increase'),
(10, 4, 'Optimize packaging designs to reduce material usage without compromising product protection, aiming for a 5% reduction in packaging waste. This involves evaluating current packaging solutions and implementing more efficient designs.', 'percentage reduction'),
(11, 4, 'Switch to recyclable or compostable packaging materials where feasible, aiming for a 5% increase in the use of sustainable packaging options within the company.', 'percentage increase'),
(12, 4, 'Educate employees and customers on proper packaging disposal and recycling practices to improve recovery rates by 5%, including training sessions and informational materials.', 'percentage improvement'),
(13, 5, 'Implement telecommuting and video conferencing options to reduce the need for employee travel, thereby aiming to reduce transportation-related emissions by 10%.', 'percentage reduction'),
(14, 5, 'Invest in energy-efficient equipment and technologies to reduce operational carbon emissions by 5%. This includes upgrading HVAC systems and other high-energy-consuming equipment.', 'percentage reduction'),
(15, 5, 'Purchase renewable energy certificates to offset the remaining carbon emissions, targeting a 5% decrease in net carbon emissions.', 'percentage reduction'),
(16, 6, 'Install solar panels or establish contracts to purchase renewable energy from local providers, with a goal to meet 20% of the company energy needs from renewable sources within the next year.', 'percentage of energy needs met'),
(17, 6, 'Educate employees on energy-saving practices to foster a culture of sustainability, aiming to reduce overall energy consumption by 5% through behavioral changes.', 'percentage reduction'),
(18, 7, 'Implement water-saving technologies such as low-flow faucets and toilets across company facilities, aiming for a 10% reduction in water usage.', 'percentage reduction'),
(19, 7, 'Conduct regular leak detection and repair programs to decrease water waste by 5%, ensuring that all plumbing systems are operating efficiently.', 'percentage reduction'),
(20, 7, 'Educate employees on water conservation practices to achieve a 5% reduction in water consumption. Initiatives include awareness campaigns and reminders to use water judiciously.', 'percentage reduction'),
(21, 8, 'Collaborate with suppliers to assess and improve their environmental performance, aiming to reduce overall supply chain emissions by 5%. This includes partnering with suppliers to implement sustainable practices.', 'percentage reduction'),
(22, 8, 'Source materials locally to reduce transportation emissions and support the local economy, targeting a 10% increase in local procurement.', 'percentage increase'),
(23, 8, 'Implement supplier sustainability requirements and conduct audits to ensure 100% compliance with environmental standards within 12 months.', 'percentage compliance'),
(24, 9, 'Stay informed about relevant environmental regulations and ensure 100% compliance with legal requirements within the next 12 months.', 'percentage compliance'),
(25, 9, 'Conduct regular environmental audits and risk assessments to address all identified non-compliance issues, ensuring that the company remains proactive in its compliance efforts.', 'address non-compliance issues'),
(26, 9, 'Provide comprehensive employee training on environmental laws, regulations, and company policies, aiming to train 100% of employees within the next year.', 'percentage of employees trained'),
(27, 10, 'Publish annual sustainability reports that detail progress towards sustainability goals, including achieving at least 95% of all established sustainability-related KPIs. The report will cover key areas such as energy efficiency, waste reduction, water usage, and sustainable sourcing, and outline future targets and planned initiatives.', 'percentage of KPIs achieved'),
(28, 10, 'Engage with stakeholders through transparent communication channels to achieve a 25% increase in stakeholder engagement, fostering an inclusive dialogue on sustainability issues within the next 12 months.', 'percentage increase'),
(29, 10, 'Participate in at least three industry sustainability initiatives and benchmarking programs within the next year to demonstrate the company commitment to continuous improvement in sustainability.', 'number of programs joined');

-- --------------------------------------------------------

--
-- Table structure for table `sustainable_measures`
--

CREATE TABLE `sustainable_measures` (
  `measure_id` int(10) UNSIGNED NOT NULL,
  `measure_type` varchar(50) NOT NULL,
  `description` text NOT NULL,
  `image_path` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `sustainable_measures`
--

INSERT INTO `sustainable_measures` (`measure_id`, `measure_type`, `description`, `image_path`) VALUES
(1, 'Waste Reduction', 'Assesses the commitment of the company to minimizing waste generation and increasing recycling rates.', '../img/measures/waste_reduction.jpg'),
(2, 'Energy-Efficient Infrastructure', 'Examines the energy efficiency of the buildings, facilities, and manufacturing processes within the company.', 'img/measures/infrastructure.jpg'),
(3, 'Eco-friendly Products/Services', 'Measures the product or service offerings of the company that have environmentally friendly attributes.', 'img/measures/products.jpg'),
(4, 'Sustainable Packaging', 'Assesses the eco-friendliness of the packaging materials and practices of the company.', 'img/measures/packaging.jpg'),
(5, 'Carbon Emissions Reduction', 'Measures efforts of the company to reduce its carbon emissions through energy-efficient practices, renewable energy sources, and emission reduction initiatives.', 'img/measures/carbon.jpg'),
(6, 'Renewable Energy Usage', 'Evaluates the percentage of energy consumption derived from renewable sources such as solar, wind, or hydropower, within the company.', 'img/measures/solar_panel.jpg'),
(7, 'Water Conservation', 'Measures the initiatives of the company to reduce water consumption and promote water conservation practices.', 'img/measures/water_conservation.jpg'),
(8, 'Sustainable Supply Chain', 'Evaluates the sustainability of the supply chain, considering the environmental impact of raw material sourcing and transportation, within the company.', 'img/measures/renewable.jpg'),
(9, 'Environmental Compliance', 'Assesses the adherence of the company to environmental regulations and standards, ensuring legal compliance.', 'img/measures/remote.jpg'),
(10, 'Transparency and Reporting', 'Assesses the transparency of the sustainability practices, including the publication of annual sustainability reports and adherence to reporting standards of the company.', 'img/measures/reporting.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `update_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `summary` text NOT NULL,
  `posted_date` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`update_id`, `title`, `summary`, `posted_date`) VALUES
(1, 'New Sustainability Goals', 'We have updated our sustainability goals to include new targets for 2024.', '2024-05-02 12:48:27'),
(2, 'Annual Report Released', 'Our annual sustainability report is now available. It highlights key achievements and future plans.', '2024-05-02 12:48:27'),
(3, 'Community Clean-up Success', 'Thanks to our volunteers, the community clean-up event was a success, with over two tons of waste collected.', '2024-05-02 12:48:27'),
(4, 'Our goals update', 'Carbon Footprint Reduction: Reduce our total carbon emissions by 30% by 2025.\nWaste Management: Achieve zero waste to landfill by 2023 through comprehensive recycling and waste reduction strategies.\nSustainable Sourcing: Ensure that 75% of our raw materials are sourced from certified sustainable sources by 2024.\nEnergy Efficiency: Increase energy efficiency across all operations by 40% by 2025 using state-of-the-art technology and process improvements.', '2024-05-02 12:48:27');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(10) UNSIGNED NOT NULL,
  `first_name` varchar(20) NOT NULL,
  `last_name` varchar(40) NOT NULL,
  `email` varchar(60) NOT NULL,
  `password_hash` varchar(256) NOT NULL,
  `card_number` varchar(20) NOT NULL,
  `exp_month` varchar(2) NOT NULL,
  `exp_year` int(4) NOT NULL,
  `cvv` int(4) DEFAULT NULL,
  `reg_date` datetime NOT NULL,
  `temp_pass` tinyint(1) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `first_name`, `last_name`, `email`, `password_hash`, `card_number`, `exp_month`, `exp_year`, `cvv`, `reg_date`, `temp_pass`) VALUES
(1, 'Danna', 'Sequeiros Huillca', 'dannasequeiros@gmail.com', '$2y$10$yG2ZaPr.bO5xX7FxySnBGuB.b9KqMabxi3XKq/sZHj/m13ntocTem', '1111111111111114', '04', 2028, 111, '2024-05-01 20:30:50', 0),
(2, 'Ana', 'Lopez Sans', 'analopez@gmail.com', '$2y$10$5vSMJrOMmyNNY5KT75szzOkJ61vymO7rP/9JrxWfRVcnjlPqQqELi', '2222222222222222', '22', 22, 222, '2024-05-02 02:32:59', 0),
(3, 'Joe', 'Doe', 'joedoe@gmail.com', '$2y$10$QaFJiYGpbo2RvSICnHnVreqeRJXkbe3iu7ZfuYg0Wy94Nlg39F6/.', '3333333333333333', '33', 33, 333, '2024-05-03 21:17:07', 0),
(5, 'Gian', 'Palau', 'gianpalau@gmail.com', '$2y$10$eVyrXLy9YkeqYS0y2c3fQee7gtka3ixf6h2x/0KCMW790E6bmuf7W', '5555555555555555', '55', 55, 55, '2024-05-04 16:29:33', 0),
(6, 'Luis', 'Fonsi', 'luisfonsi@gmail.com', '$2y$10$qIO9DskWGI.8VuOcvqgKZ.x/hdbeXeOkzORUxNLlFgLCNdT5duyY2', '6666666666666666', '66', 66, 666, '2024-05-05 17:10:57', 0),
(7, 'Ana', 'Sans', 'anasans@gmail.com', '$2y$10$skBwVZ5OrCSv0aeSbtf4T.PyAiaHNdcaouJFuAKe3pKRhyLvHYn1G', '7777777777777777', '07', 2027, 777, '2024-05-05 20:12:00', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin_users`
--
ALTER TABLE `admin_users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indexes for table `certificates`
--
ALTER TABLE `certificates`
  ADD PRIMARY KEY (`certificate_id`);

--
-- Indexes for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  ADD PRIMARY KEY (`template_id`);

--
-- Indexes for table `companies`
--
ALTER TABLE `companies`
  ADD PRIMARY KEY (`company_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `companies_certificates`
--
ALTER TABLE `companies_certificates`
  ADD PRIMARY KEY (`certificate_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `achievement_id` (`achievement_id`);

--
-- Indexes for table `company_achievements`
--
ALTER TABLE `company_achievements`
  ADD PRIMARY KEY (`achievement_id`),
  ADD KEY `company_id` (`company_id`),
  ADD KEY `measure_id` (`measure_id`),
  ADD KEY `voucher_id` (`voucher_id`);

--
-- Indexes for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD PRIMARY KEY (`inquiry_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `green_vouchers`
--
ALTER TABLE `green_vouchers`
  ADD PRIMARY KEY (`voucher_id`);

--
-- Indexes for table `partners`
--
ALTER TABLE `partners`
  ADD PRIMARY KEY (`partner_id`);

--
-- Indexes for table `site_content`
--
ALTER TABLE `site_content`
  ADD PRIMARY KEY (`content_id`);

--
-- Indexes for table `sustainability_activities`
--
ALTER TABLE `sustainability_activities`
  ADD PRIMARY KEY (`activity_id`),
  ADD KEY `measure_id` (`measure_id`);

--
-- Indexes for table `sustainable_measures`
--
ALTER TABLE `sustainable_measures`
  ADD PRIMARY KEY (`measure_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`update_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin_users`
--
ALTER TABLE `admin_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `certificates`
--
ALTER TABLE `certificates`
  MODIFY `certificate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `certificate_templates`
--
ALTER TABLE `certificate_templates`
  MODIFY `template_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `companies`
--
ALTER TABLE `companies`
  MODIFY `company_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `companies_certificates`
--
ALTER TABLE `companies_certificates`
  MODIFY `certificate_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `company_achievements`
--
ALTER TABLE `company_achievements`
  MODIFY `achievement_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `contact_us`
--
ALTER TABLE `contact_us`
  MODIFY `inquiry_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `green_vouchers`
--
ALTER TABLE `green_vouchers`
  MODIFY `voucher_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `partners`
--
ALTER TABLE `partners`
  MODIFY `partner_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `site_content`
--
ALTER TABLE `site_content`
  MODIFY `content_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `sustainability_activities`
--
ALTER TABLE `sustainability_activities`
  MODIFY `activity_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `sustainable_measures`
--
ALTER TABLE `sustainable_measures`
  MODIFY `measure_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `update_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `companies`
--
ALTER TABLE `companies`
  ADD CONSTRAINT `companies_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `companies_certificates`
--
ALTER TABLE `companies_certificates`
  ADD CONSTRAINT `companies_certificates_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `companies_certificates_ibfk_2` FOREIGN KEY (`achievement_id`) REFERENCES `company_achievements` (`achievement_id`) ON DELETE SET NULL;

--
-- Constraints for table `company_achievements`
--
ALTER TABLE `company_achievements`
  ADD CONSTRAINT `company_achievements_ibfk_1` FOREIGN KEY (`company_id`) REFERENCES `companies` (`company_id`) ON DELETE CASCADE,
  ADD CONSTRAINT `company_achievements_ibfk_2` FOREIGN KEY (`measure_id`) REFERENCES `sustainable_measures` (`measure_id`) ON DELETE SET NULL,
  ADD CONSTRAINT `company_achievements_ibfk_3` FOREIGN KEY (`voucher_id`) REFERENCES `green_vouchers` (`voucher_id`) ON DELETE SET NULL;

--
-- Constraints for table `contact_us`
--
ALTER TABLE `contact_us`
  ADD CONSTRAINT `contact_us_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`) ON DELETE CASCADE;

--
-- Constraints for table `sustainability_activities`
--
ALTER TABLE `sustainability_activities`
  ADD CONSTRAINT `sustainability_activities_ibfk_1` FOREIGN KEY (`measure_id`) REFERENCES `sustainable_measures` (`measure_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
