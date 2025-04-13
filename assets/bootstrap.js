import { startStimulusApp } from '@symfony/stimulus-bundle';
import CharacterCounter from "@stimulus-components/character-counter";

const app = startStimulusApp();
app.register("character-counter", CharacterCounter);
// register any custom, 3rd party controllers here
// app.register('some_controller_name', SomeImportedController);
