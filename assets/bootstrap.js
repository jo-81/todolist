import { startStimulusApp } from '@symfony/stimulus-bundle';
import CharacterCounter from "@stimulus-components/character-counter";
import ReadMore from "@stimulus-components/read-more";

const app = startStimulusApp();
app.register("character-counter", CharacterCounter);
app.register("read-more", ReadMore);
