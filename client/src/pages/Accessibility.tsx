/*
 * Accessibility Page — Restwell Retreats
 * Design: Coastal Calm / Organic Minimalism
 */
import Layout from "@/components/Layout";
import { Link } from "wouter";
import { ArrowRight, Check } from "lucide-react";

export default function Accessibility() {
  return (
    <Layout>
      {/* Header */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            Accessibility
          </span>
          <h1 className="text-4xl md:text-5xl mb-6">Honest detail, so you can decide</h1>
          <p className="text-[#3a5a63] text-lg leading-relaxed">
            We don't just say we're "accessible" and leave it at that. This page gives you the practical, honest detail you need to decide whether our property works for you. If something isn't confirmed yet, we say so. If something doesn't work for wheelchair users, we say that too.
          </p>
        </div>
      </section>

      {/* Property Accessibility Details */}
      <section className="py-16 md:py-24">
        <div className="container max-w-4xl">
          <h2 className="text-3xl mb-10">The property: room by room</h2>

          <div className="space-y-8">
            {/* Arrival */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Arrival &amp; entrance</h3>
              <div className="space-y-3">
                <div className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#A8D5D0]/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check size={14} className="text-[#1B4D5C]" />
                  </div>
                  <span className="text-[#3a5a63]">Level threshold with a wide front door</span>
                </div>
                <div className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#A8D5D0]/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check size={14} className="text-[#1B4D5C]" />
                  </div>
                  <span className="text-[#3a5a63]">Quiet, flat residential street with no steep approach</span>
                </div>
                <p className="text-[#8B8B7A] italic text-sm pl-9">
                  PLACEHOLDER – Exact door width measurement to be confirmed by client.
                </p>
                <p className="text-[#8B8B7A] italic text-sm pl-9">
                  PLACEHOLDER – Parking arrangements (driveway, dropped kerb, blue badge space) to be confirmed by client.
                </p>
              </div>
            </div>

            {/* Inside */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Inside the property</h3>
              <div className="space-y-3">
                <div className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#A8D5D0]/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check size={14} className="text-[#1B4D5C]" />
                  </div>
                  <span className="text-[#3a5a63]">Level access throughout the ground floor</span>
                </div>
                <div className="flex items-start gap-3">
                  <div className="w-6 h-6 rounded-full bg-[#A8D5D0]/30 flex items-center justify-center flex-shrink-0 mt-0.5">
                    <Check size={14} className="text-[#1B4D5C]" />
                  </div>
                  <span className="text-[#3a5a63]">Wide doorways suitable for standard and power wheelchairs</span>
                </div>
                <p className="text-[#8B8B7A] italic text-sm pl-9">
                  PLACEHOLDER – Turning circle dimensions in key rooms to be confirmed by client.
                </p>
                <p className="text-[#8B8B7A] italic text-sm pl-9">
                  PLACEHOLDER – Whether the property is single-storey or has accessible upper floor to be confirmed by client.
                </p>
              </div>
            </div>

            {/* Bedroom */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Bedrooms</h3>
              <p className="text-[#8B8B7A] italic text-sm">
                PLACEHOLDER – Number of bedrooms, bed types, bed heights, transfer space beside beds, and any profiling bed availability to be confirmed by client.
              </p>
            </div>

            {/* Bathroom */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Bathroom</h3>
              <p className="text-[#8B8B7A] italic text-sm">
                PLACEHOLDER – Full bathroom details to be confirmed by client. Key items to verify: wet room or level-access shower, grab rails, shower seat, toilet height, turning space, and whether a ceiling hoist or mobile hoist is available.
              </p>
            </div>

            {/* Kitchen */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Kitchen</h3>
              <p className="text-[#8B8B7A] italic text-sm">
                PLACEHOLDER – Kitchen accessibility features to be confirmed by client. Key items: counter heights, wheelchair-accessible workspace, accessible appliance controls.
              </p>
            </div>

            {/* Outdoor */}
            <div className="bg-white rounded-2xl p-8 shadow-sm">
              <h3 className="text-xl mb-4">Outdoor spaces</h3>
              <p className="text-[#8B8B7A] italic text-sm">
                PLACEHOLDER – Garden and outdoor area accessibility to be confirmed by client. Key items: level patio, step-free access from house to garden, surface type.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Whitstable as a Destination */}
      <section className="py-16 md:py-24 bg-white">
        <div className="container max-w-3xl">
          <span className="text-[#D4A853] text-sm font-semibold uppercase tracking-[0.2em] block mb-4" style={{ fontFamily: "'Inter', sans-serif" }}>
            The destination
          </span>
          <h2 className="text-3xl mb-6">Whitstable: what to expect</h2>

          <div className="space-y-6 text-[#3a5a63] text-lg leading-relaxed">
            <div>
              <h3 className="text-xl text-[#1B4D5C] mb-2">The good</h3>
              <p>
                The <strong>Tankerton Slopes promenade</strong> is one of the best level coastal walks in Kent — a long, flat concrete path with stunning sea views, suitable for wheelchairs and pushchairs. There are accessible toilets at the harbour end. The area around Russell Drive is generally flat and easy to navigate.
              </p>
            </div>

            <div>
              <h3 className="text-xl text-[#1B4D5C] mb-2">The challenge</h3>
              <p>
                <strong>Harbour Street</strong> and the old town centre have some narrow pavements that can be crowded during peak times and weekends. We recommend visiting during quieter weekday mornings for the most comfortable experience. Some shops may have stepped entrances.
              </p>
            </div>

            <div>
              <h3 className="text-xl text-[#D4A853] mb-2">The reality</h3>
              <p>
                Whitstable's beach is <strong>shingle</strong>. We want to be honest: shingle beaches are generally not wheelchair-friendly. The stones are loose and uneven, making wheeled access very difficult. However, the promenade above the beach provides excellent views and is fully accessible. There are also accessible cafes and restaurants along the seafront at street level.
              </p>
              <p className="mt-3 text-[#8B8B7A] italic text-base">
                PLACEHOLDER – Information about any beach wheelchair loan scheme or specific accessible viewing points to be confirmed.
              </p>
            </div>
          </div>
        </div>
      </section>

      {/* Contact for Questions */}
      <section className="py-16 md:py-24">
        <div className="container max-w-3xl text-center">
          <h2 className="text-3xl mb-6">Still have questions?</h2>
          <p className="text-[#3a5a63] text-lg leading-relaxed max-w-2xl mx-auto mb-8">
            We understand that accessibility details matter — and that everyone's needs are different. If you have specific questions about the property, the local area, or anything else, please get in touch. We are happy to talk through your requirements in detail before you book.
          </p>
          <Link
            href="/contact"
            className="inline-flex items-center gap-2 bg-[#1B4D5C] text-white font-semibold px-8 py-3 rounded-full hover:bg-[#164350] transition-colors duration-300 no-underline"
          >
            Ask us anything <ArrowRight size={18} />
          </Link>
        </div>
      </section>
    </Layout>
  );
}
