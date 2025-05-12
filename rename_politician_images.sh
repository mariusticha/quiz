#!/bin/bash

cd "$(dirname "$0")"

# Create a backup of the original files
mkdir -p public/storage/politicians/backup
cp public/storage/politicians/*.jpg public/storage/politicians/backup/

# Rename files
cd public/storage/politicians

mv "37922781-fritze-merz-kabinett-cdu-csu-minister-Oz73.jpg" "friedrich-merz.jpg"
mv "37997630-klingbeil-kabinett-vizekanzler-finanzminister-Re73.jpg" "lars-klingbeil.jpg"
mv "37924256-dobrindt-innenminister-csu-kabinett-merz-liste-P273.jpg" "alexander-dobrindt.jpg"
mv "37922780-johann-wadephul-aussenminister-merz-kabinett-QM73.jpg" "johann-wadephul.jpg"
mv "37997627-boris-pistorius-verteidigunsminister-spd-merz-klingbgeil-Pm73.jpg" "boris-pistorius.jpg"
mv "37922776-katherina-reiche-wirtschaftsministerin-merz-kabinett-Os73.jpg" "katherina-reiche.jpg"
mv "37924257-baer-ministerin-soeder-merz-kabinett-OS73.jpg" "dorothee-baer.jpg"
mv "37997628-hubig-justiz-56-spd-merz-kabinett-OS73.jpg" "stefanie-hubig.jpg"
mv "37922777-karin-prien-bildungsministerin-familie-merz-kabinett-NW73.jpg" "karin-prien.jpg"
mv "37997629-bas-ministerin-arbeit-kabinett-QP73.jpg" "baerbel-bas.jpg"
mv "37922785-karsten-wildberger-digitalminister-merz-kabinett-Pg73.jpg" "karsten-wildberger.jpg"
mv "37924389-schnieder-vekehrsminister-cdu-kabinett-merz-NZ73.jpg" "patrick-schnieder.jpg"
mv "37997625-carsten-schneider-spd-umweltminister-merz-klingbeil-kabinett-Pd73.jpg" "carsten-schneider.jpg"
mv "37922782-nina-warken-gesundheitsministerin-kabinett-merz-Qg73.jpg" "nina-warken.jpg"
mv "37924260-alois-rainer-landwirtschaft-merz-kabinett-NN73.jpg" "alois-rainer.jpg"
mv "37997626-reem-alabali-radovan-bundesministerin-fuer-wirtschaftliche-zusammenarbeit-und-entwicklung-NN73.jpg" "reem-alabali-radovan.jpg"
mv "37997631-hubertz-wohnen-bauministerin-spd-kabinett-merz-klingbeiil-R273.jpg" "verena-hubertz.jpg"
mv "37922773-thorsten-frei-kanzleramtsminister-merz-kabinett-OQ73.jpg" "thorsten-frei.jpg"

echo "Images have been renamed successfully. Original files were backed up in public/storage/politicians/backup/"
