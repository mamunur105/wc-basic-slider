const mix = require("laravel-mix");
const fs = require("fs-extra");
const path = require("path");
const cliColor = require("cli-color");
const emojic = require("emojic");
const wpPot = require("wp-pot");
const archiver = require("archiver");
const min = mix.inProduction() ? ".min" : "";

const package_path = path.resolve(__dirname);
const package_slug = path.basename(path.resolve(package_path));
const temDirectory = package_path + "/dist";

mix.options({
	terser: {
		extractComments: false,
	},
	processCssUrls: false,
});

if (process.env.npm_config_package) {
	mix.then(function () {
		const copyTo = path.resolve(`${temDirectory}/${package_slug}`);
		// Select All file then paste on list
		let includes = [
			"assets",
			"languages",
			"lib",
			"templates",
			"vendor",
			"basic-slider.php",
			"index.php",
			"LICENSE.txt",
			"readme.txt",
			"uninstall.php",
			`${package_slug}.php`,
		];
		fs.ensureDir(copyTo, function (err) {
			if (err) return console.error(err);
			includes.map((include) => {
				fs.copy(
					`${package_path}/${include}`,
					`${copyTo}/${include}`,
					function (err) {
						if (err) return console.error(err);
						console.log(
							cliColor.white(`=> ${emojic.smiley}  ${include} copied...`)
						);
					}
				);
			});
			console.log(
				cliColor.white(`=> ${emojic.whiteCheckMark}  Build directory created`)
			);
		});
	});

	return;
}

if (
	!process.env.npm_config_block &&
	!process.env.npm_config_package &&
	(process.env.NODE_ENV === "development" ||
		process.env.NODE_ENV === "production")
) {
	if (mix.inProduction()) {
		let languages = path.resolve("languages");
		fs.ensureDir(languages, function (err) {
			if (err) return console.error(err); // if file or folder does not exist
			wpPot({
				package: "Unlimited Category slider for WooCommerce",
				bugReport: "",
				src: "**/*.php",
				domain: "bs-slider",
				destFile: `languages/${package_slug}.pot`,
			});
		});
	}

	// Frontend CSS
	if (!mix.inProduction()) {
		/**
		 * JS
		 */
		mix
			// Backend JS
			.js("src/scripts/admin.js", "assets/scripts/")
			.js("src/scripts/frontend.js", "assets/scripts/")
			// Backend CSS
			.sass('src/styles/admin.scss', 'assets/styles/')
			.sass('src/styles/frontend.scss', 'assets/styles/')
			.sourceMaps(true, 'source-map');
	} else {
		/**
		 * JS
		 */
		mix
			// Backend JS
			.js("src/scripts/admin.js", "assets/scripts/")
			.js("src/scripts/frontend.js", "assets/scripts/")
			// Backend CSS
			.sass('src/styles/admin.scss', 'assets/styles/')
			.sass('src/styles/frontend.scss', 'assets/styles/');
	}

}
if (process.env.npm_config_zip) {
	async function getVersion() {
		let data;
		try {
			data = await fs.readFile(package_path + `/${package_slug}.php`, "utf-8");
		} catch (err) {
			console.error(err);
		}
		const lines = data.split(/\r?\n/);
		let version = "";
		for (let i = 0; i < lines.length; i++) {
			if (lines[i].includes("* Version:") || lines[i].includes("*Version:")) {
				version = lines[i]
					.replace("* Version:", "")
					.replace("*Version:", "")
					.trim();
				break;
			}
		}
		return version;
	}

	const version_get = getVersion();
	version_get.then(function (version) {
		const destinationPath = `${temDirectory}/${package_slug}.${version}.zip`;
		const output = fs.createWriteStream(destinationPath);
		const archive = archiver("zip", { zlib: { level: 9 } });
		output.on("close", function () {
			console.log(archive.pointer() + " total bytes");
			console.log(
				"Archive has been finalized and the output file descriptor has closed."
			);
			fs.removeSync(`${temDirectory}/${package_slug}`);
		});
		output.on("end", function () {
			console.log("Data has been drained");
		});
		archive.on("error", function (err) {
			throw err;
		});

		archive.pipe(output);
		archive.directory(`${temDirectory}/${package_slug}`, package_slug);
		archive.finalize();
	});
}
