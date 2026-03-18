/*
 * The Property Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { IMAGES } from "@/lib/constants";
import { ArrowRight, Check } from "lucide-react";

export default function Property() {
  return (
    <Layout>
      {/* Hero */}
      <section className="relative h-[50vh] md:h-[60vh] overflow-hidden">
        <img
          src={IMAGES.interior}
          alt="The bright, spacious living room of the Restwell Retreats holiday home with wide doorways, natural light, and coastal decor"
          className="absolute inset-0 w-full h-full object-cover"
        />
        <div className="absolute inset-0 bg-gradient-to-t from-[#1B4D5C]/70 to-transparent" />
        <div className="relative container h-full flex items-end pb-12">
          <div>
            <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-3" style={{ fontFamily: "'Inter', sans-serif" }}>
              The Property
            </span>
            <h1 className="text-white text-4xl md:text-5xl">101 Russell Drive, Whitstable</h1>
          </div>
        </div>
      </section>

      {/* Property Overview */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl">
          <h2 className="text-3xl mb-6">Your coastal home-from-home</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed mb-6">
            101 Russell Drive is more than just a place to stay — it is your base for a proper coastal break. Located in a quiet residential corner of Whitstable, this property blends modern comfort with thoughtful accessibility. The neighbourhood is peaceful and flat, making it easy to get out and about whether you are on foot or using a wheelchair.
          </p>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            Whitstable itself is one of Kent's most charming towns. Famous for its oysters, independent shops along Harbour Street, and a thriving arts scene, it has a relaxed, authentic atmosphere that feels a world away from the everyday — without being difficult to reach.
          </p>
        </div>
      </section>

      {/* Accessibility Features */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-4xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Accessibility
          </span>
          <h2 className="text-3xl mb-8">What we can confirm</h2>
          <p className="text-[#3a5a63] mb-8 leading-relaxed">
            We believe in being upfront about what the property offers. Below are the features we can confirm, along with items that still need verification from the property owner.
          </p>
          <div className="grid md:grid-cols-2 gap-6">
            <div className="space-y-4">
              <h3 className="text-xl text-[#1B4D5C]">Confirmed features</h3>
              {[
                "Level access throughout the ground floor",
                "Wide doorways suitable for wheelchair access",
                "Quiet, flat residential street",
                "Close to level promenade walks",
              ].map((item, i) => (
                <div key={i} className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#A8D5D0]/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check size={14} className="text-[#1B4D5C]" />
                  </div>
                  <span className="text-[#3a5a63]">{item}</span>
                </div>
              ))}
            </div>
            <div className="space-y-4">
              <h3 className="text-xl text-[#8B8B7A]">To be confirmed</h3>
              {[
                "PLACEHOLDER – Bathroom layout and equipment (e.g. wet room, grab rails, shower seat) to be confirmed by client",
                "PLACEHOLDER – Kitchen accessibility features (e.g. lowered counters, accessible appliances) to be confirmed by client",
                "PLACEHOLDER – Bedroom configuration and bed types to be confirmed by client",
                "PLACEHOLDER – Outdoor space accessibility (e.g. patio, ramp to garden) to be confirmed by client",
              ].map((item, i) => (
                <div key={i} className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#D4A853]/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <span className="text-[#D4A853] text-xs font-bold">?</span>
                  </div>
                  <span className="text-[#8B8B7A] text-sm italic">{item}</span>
                </div>
              ))}
            </div>
          </div>
        </div>
      </section>

      {/* Photo Gallery */}
      <section className="py-16 md:py-24">
        <div className="container">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Gallery
          </span>
          <h2 className="text-3xl mb-8">See the space</h2>
          <div className="grid grid-cols-1 md:grid-cols-2 gap-4">
            <img
              src={IMAGES.interior}
              alt="Spacious open-plan living area with wide doorways, natural light, and warm coastal decor"
              className="rounded-2xl w-full h-[300px] md:h-[400px] object-cover"
            />
            <img
              src={IMAGES.outdoor}
              alt="Private garden with level patio, coastal plants, and a distant sea view — perfect for relaxing outdoors"
              className="rounded-2xl w-full h-[300px] md:h-[400px] object-cover"
            />
            <img
              src={IMAGES.heroCoastal}
              alt="The nearby Tankerton promenade at golden hour — a wide, flat, concrete walkway with colourful beach huts"
              className="rounded-2xl w-full h-[300px] md:h-[400px] object-cover md:col-span-2"
            />
          </div>
        </div>
      </section>

      {/* Practical Details */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-4xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Practical details
          </span>
          <h2 className="text-3xl mb-8">The essentials</h2>
          <div className="grid sm:grid-cols-2 gap-x-12 gap-y-6">
            <div>
              <h3 className="text-lg text-[#1B4D5C] mb-2">Bedrooms</h3>
              <p className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Number of bedrooms and bed types to be confirmed by client.</p>
            </div>
            <div>
              <h3 className="text-lg text-[#1B4D5C] mb-2">Bathroom</h3>
              <p className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Bathroom type and accessibility features to be confirmed by client.</p>
            </div>
            <div>
              <h3 className="text-lg text-[#1B4D5C] mb-2">Parking</h3>
              <p className="text-[#8B8B7A] italic text-sm">PLACEHOLDER – Driveway or street parking details to be confirmed by client.</p>
            </div>
            <div>
              <h3 className="text-lg text-[#1B4D5C] mb-2">Distances</h3>
              <p className="text-[#3a5a63]">Approximately 15 minutes' flat walk to the Tankerton promenade. Around 7 minutes' drive to Whitstable town centre and harbour.</p>
            </div>
          </div>
        </div>
      </section>

      {/* What's Nearby */}
      <section className="py-16 md:py-24">
        <div className="container max-w-4xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            What's nearby
          </span>
          <h2 className="text-3xl mb-8">Explore Whitstable</h2>

          <div className="space-y-8">
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-3">The Plough Pub</h3>
              <p className="text-[#3a5a63] leading-relaxed mb-3">
                A friendly local pub on St John's Road, just a short walk from the property. The Plough has a relaxed, casual atmosphere with good food (around £10–20 per person), live music nights, and a welcoming vibe for families and groups.
              </p>
              <p className="text-[#1B4D5C] font-medium text-sm">
                Accessibility: Wheelchair-accessible entrance, accessible parking, and an accessible restroom (confirmed via Google Maps).
              </p>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-3">Tankerton Slopes &amp; Promenade</h3>
              <p className="text-[#3a5a63] leading-relaxed mb-3">
                One of the best level coastal walks in Kent. The long, flat concrete promenade stretches along the seafront with stunning views across the Thames Estuary. It is wheelchair and pushchair friendly, with accessible toilets at the harbour end.
              </p>
              <p className="text-[#1B4D5C] font-medium text-sm">
                Accessibility: Level concrete surface, suitable for wheelchairs. Accessible WC available.
              </p>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-3">Whitstable Beach</h3>
              <p className="text-[#3a5a63] leading-relaxed mb-3">
                Whitstable's beach is characteristically shingle — beautiful to look at, but we want to be honest: shingle is generally not wheelchair-friendly. However, the promenade above the beach provides excellent sea views and level access, and there are accessible cafes and restaurants along the seafront.
              </p>
              <p className="text-[#D4A853] font-medium text-sm">
                Honest note: The shingle beach itself is difficult for wheelchair users. We recommend the promenade for the best accessible coastal experience.
              </p>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-3">Whitstable Town Centre &amp; Harbour Street</h3>
              <p className="text-[#3a5a63] leading-relaxed mb-3">
                The heart of Whitstable is Harbour Street — a charming strip of independent shops, galleries, and cafes. The town has a relaxed, artistic character that draws visitors year-round. The harbour itself is a lovely spot for fresh seafood.
              </p>
              <p className="text-[#8B8B7A] italic text-sm">
                Accessibility note: Some pavements in the old town are narrow and can be crowded during peak times. We recommend visiting during quieter weekday mornings for the most comfortable experience. Accessibility details: PLACEHOLDER – specific shop-level access to be confirmed.
              </p>
            </div>

            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-3">Nearby Medical Services</h3>
              <p className="text-[#3a5a63] leading-relaxed">
                For peace of mind: <strong>Swalecliffe Pharmacy</strong> is approximately 0.3 miles away on St John's Road. <strong>Chestfield Medical Centre</strong> (GP surgery) is around 0.5 miles away. The <strong>Estuary View Urgent Treatment Centre</strong> is approximately 1.5 miles away on Boorman Way, open until 8 PM with a free car park and on-site pharmacy.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* CTA */}
      <section className="py-16 md:py-20 bg-[#1B4D5C] text-center">
        <div className="container">
          <h2 className="text-white text-3xl mb-4">Like what you see?</h2>
          <p className="text-[#A8D5D0] text-lg mb-8 max-w-md mx-auto">
            Get in touch to check availability or ask any questions about the property.
          </p>
          <Link
            href="/contact"
            className="inline-flex items-center gap-2 bg-[#D4A853] text-[#1B4D5C] font-semibold px-8 py-3 rounded-full hover:bg-[#c49a48] transition-colors duration-300 no-underline"
          >
            Enquire now <ArrowRight size={18} />
          </Link>
        </div>
      </section>
    </Layout>
  );
}
